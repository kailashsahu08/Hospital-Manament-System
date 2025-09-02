# System Architecture

This document explains how the Hospital Management System is structured, including layers, modules, data models, and application flow.

## High-Level Architecture

- Presentation Layer: Filament Admin Panel (Livewire + Alpine.js), Filament Pages/Resources/Widgets
- Application Layer: Laravel controllers, Filament resources, policies, and form/table components
- Domain Layer: Eloquent models and business rules
- Data Layer: Migrations, seeders, database (MySQL/SQLite)

## Key Modules

- Authentication and Authorization
  - Laravel auth scaffolding (Filament auth pages)
  - Spatie Roles & Permissions for RBAC
  - Policies guarding resource actions

- User Management
  - Users (Admin/Doctor/Patient) with roles
  - UserResource for CRUD

- Departments
  - Department model with name, description, is_active
  - DepartmentResource for CRUD

- Doctors
  - Doctor model linked to User and Department
  - Appointments relation
  - DoctorResource for CRUD

- Patients
  - Patient model linked to User
  - Appointments and TestReports relations
  - PatientResource for CRUD

- Appointments
  - Appointment model links Doctor, Patient, Department
  - Payment relation (hasOne)
  - Calendar widget via filament-fullcalendar

- Payments
  - Payment model links Appointment and Patient

- Test Reports
  - TestReport model links Patient and Doctor

## Data Model Overview

- User (id, name, email, password, roles)
- Department (id, name, description, is_active)
- Doctor (id, user_id, department_id, specialization, availability_*, fee, ...)
- Patient (id, user_id, medical profile fields, ...)
- Appointment (id, doctor_id, patient_id, department_id, date/time, status, type, notes, follow-up)
- Payment (id, appointment_id, patient_id, amounts, status, invoice)
- TestReport (id, patient_id, doctor_id, test details, critical flag, follow-up)

## Relationships

- User 1—1 Doctor (optional)
- User 1—1 Patient (optional)
- Department 1—N Doctor
- Doctor 1—N Appointment
- Patient 1—N Appointment
- Appointment 1—1 Payment
- Patient 1—N TestReport
- Doctor 1—N TestReport

## Authorization Flow (Spatie + Policies)

- Roles: admin, doctor, patient
- Permissions generated from policies for each model (view-any, view, create, update, delete, restore, force-delete)
- Seeder assigns all permissions to admin, limited permissions to doctor/patient
- Policies check permissions per action and are integrated with Filament resources

## Request Lifecycle

1. HTTP request enters Laravel (public/index.php)
2. Routing resolves to Filament resource/page or controller
3. Authentication middleware ensures user is logged in
4. Authorization checks via policies/permissions
5. Resource handles form/table actions (create/edit/delete/view)
6. Eloquent models persist data
7. Response rendered via Filament components

## Application Flow Examples

### Appointment Booking Flow

1. Patient (or Admin) creates an appointment from AppointmentResource
2. Selects Department -> Doctor -> Date/Time (validated against availability)
3. Appointment saved with status "Scheduled"
4. CalendarWidget displays appointment
5. Doctor views upcoming appointments; after consultation, marks as "Completed"
6. Payment record created/updated for the appointment

### Test Report Workflow

1. Doctor orders test and later creates a TestReport
2. Upload report file, set `is_critical` if needed
3. If critical or follow-up required, set `follow_up_required` and `follow_up_date`
4. Patient can view report; system may prompt follow-up appointment

### User and Role Management

1. Admin creates a user via UserResource, assigns role(s)
2. Doctors/Patients can have linked profiles in their respective models
3. Permissions enforce what each role can see/do

## Filament Components

- Resources: UserResource, DepartmentResource, DoctorResource, PatientResource, AppointmentResource, PaymentResource, PermissionResource, RoleResource, TestReportResource
- Pages: AuthLogin, AuthRegister, AuthProfile
- Widgets: StatsOverview, CalendarWidget

## Security Considerations

- Policies and permissions to restrict access
- Validations on all forms (required fields, date/time logic)
- CSRF protection via Laravel
- Rate-limiting on authentication endpoints

## Performance Considerations

- Use eager loading in Tables to avoid N+1 queries
- Cache permissions (Spatie PermissionRegistrar)
- Queue heavy tasks with `queue:work`

## Deployment Architecture

- Web server (Nginx/Apache) -> PHP-FPM 8.2 -> Laravel app
- Database: MySQL/MariaDB (managed instance or self-hosted)
- Cache/Queue: Database driver by default; can switch to Redis for scale
- Storage: Local disk with `php artisan storage:link`; use S3 in production

## Diagrams

See `docs/development/architecture.md` for additional diagrams and sequence flows.


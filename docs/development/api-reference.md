# API Reference & Database Documentation

This document provides comprehensive documentation of the Hospital Management System's data models, relationships, and core functionality for developers.

## Table of Contents

1. [Data Models](#data-models)
2. [Database Schema](#database-schema)
3. [Model Relationships](#model-relationships)
4. [Filament Resources](#filament-resources)
5. [Policies & Permissions](#policies--permissions)
6. [Seeders](#seeders)
7. [Key Functionality](#key-functionality)

## Data Models

### User Model
**File**: `app/Models/User.php`

```php
<?php
class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;
    
    protected $fillable = [
        'name',
        'email',
        'password',
    ];
    
    protected $hidden = [
        'password',
        'remember_token',
    ];
    
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
```

**Features**:
- Laravel authentication with Spatie roles
- Role-based access control (Admin, Doctor, Patient)
- Email verification support
- Password hashing

### Department Model
**File**: `app/Models/Department.php`

```php
<?php
class Department extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'description',
        'is_active'
    ];
    
    protected $casts = [
        'is_active' => 'boolean',
    ];
    
    // Relationships
    public function doctors(): HasMany
    {
        return $this->hasMany(Doctor::class);
    }
    
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }
}
```

**Database Fields**:
- `id` (Primary Key)
- `name` (String, Required)
- `description` (Text, Nullable)
- `is_active` (Boolean, Default: true)
- `created_at` (Timestamp)
- `updated_at` (Timestamp)

### Doctor Model
**File**: `app/Models/Doctor.php`

```php
<?php
class Doctor extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'name',
        'phone',
        'address',
        'city',
        'state',
        'zip_code',
        'date_of_birth',
        'gender',
        'specialization',
        'department_id',
        'license_number',
        'experience_years',
        'consultation_fee',
        'availability_start_time',
        'availability_end_time',
        'profile_picture',
        'bio'
    ];
    
    protected $casts = [
        'date_of_birth' => 'date',
        'consultation_fee' => 'decimal:2',
        'availability_start_time' => 'datetime:H:i',
        'availability_end_time' => 'datetime:H:i',
    ];
    
    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }
    
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }
    
    public function testReports(): HasMany
    {
        return $this->hasMany(TestReport::class);
    }
}
```

**Key Features**:
- Linked to User model for authentication
- Department assignment with specialization
- Availability time management
- Consultation fee tracking
- Professional details (license, experience)

### Patient Model
**File**: `app/Models/Patient.php`

```php
<?php
class Patient extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'name',
        'phone',
        'address',
        'city',
        'state',
        'zip_code',
        'date_of_birth',
        'gender',
        'blood_group',
        'allergies',
        'chronic_diseases',
        'emergency_contact_name',
        'emergency_contact_relationship',
        'emergency_contact_phone',
        'insurance_provider',
        'insurance_policy_number',
        'height',
        'weight',
        'profile_picture'
    ];
    
    protected $casts = [
        'date_of_birth' => 'date',
        'height' => 'decimal:2',
        'weight' => 'decimal:2',
    ];
    
    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }
    
    public function testReports(): HasMany
    {
        return $this->hasMany(TestReport::class);
    }
    
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
}
```

**Key Features**:
- Comprehensive medical profile
- Emergency contact information
- Insurance details management
- Physical metrics tracking
- Medical history fields

### Appointment Model
**File**: `app/Models/Appointment.php`

```php
<?php
class Appointment extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'doctor_id',
        'patient_id',
        'department_id',
        'appointment_date',
        'start_time',
        'end_time',
        'status', // Scheduled, Completed, Cancelled, No-show
        'type', // In-person, Virtual
        'reason',
        'notes',
        'is_follow_up',
        'previous_appointment_id'
    ];
    
    protected $casts = [
        'appointment_date' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'is_follow_up' => 'boolean',
    ];
    
    // Relationships
    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }
    
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }
    
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }
    
    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }
    
    public function previousAppointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class, 'previous_appointment_id');
    }
    
    public function followUpAppointments(): HasMany
    {
        return $this->hasMany(Appointment::class, 'previous_appointment_id');
    }
}
```

**Status Options**:
- `Scheduled` - Appointment is confirmed
- `Completed` - Consultation finished
- `Cancelled` - Appointment cancelled
- `No-show` - Patient didn't attend

**Type Options**:
- `In-person` - Physical consultation
- `Virtual` - Online consultation

### Payment Model
**File**: `app/Models/Payment.php`

```php
<?php
class Payment extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'appointment_id',
        'patient_id',
        'amount',
        'payment_date',
        'payment_method', // Credit Card, Cash, Insurance, etc.
        'transaction_id',
        'status', // Pending, Completed, Failed, Refunded
        'invoice_number',
        'discount',
        'tax',
        'total_amount',
        'is_insured',
        'insurance_coverage_amount',
        'patient_responsibility',
        'notes'
    ];
    
    protected $casts = [
        'payment_date' => 'date',
        'amount' => 'decimal:2',
        'discount' => 'decimal:2',
        'tax' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'insurance_coverage_amount' => 'decimal:2',
        'patient_responsibility' => 'decimal:2',
        'is_insured' => 'boolean',
    ];
    
    // Relationships
    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }
    
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }
}
```

**Payment Methods**:
- Credit Card
- Cash
- Insurance
- Bank Transfer
- Check

**Status Options**:
- `Pending` - Payment initiated
- `Completed` - Payment successful
- `Failed` - Payment failed
- `Refunded` - Payment refunded

### TestReport Model
**File**: `app/Models/TestReport.php`

```php
<?php
class TestReport extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'test_name',
        'test_date',
        'test_result',
        'result_interpretation',
        'normal_range',
        'performed_by',
        'report_file',
        'is_critical',
        'remarks',
        'follow_up_required',
        'follow_up_date'
    ];
    
    protected $casts = [
        'test_date' => 'date',
        'follow_up_date' => 'date',
        'is_critical' => 'boolean',
        'follow_up_required' => 'boolean',
    ];
    
    // Relationships
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }
    
    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }
}
```

**Key Features**:
- Test result storage and interpretation
- Critical result flagging
- Follow-up scheduling
- File attachment support

## Database Schema

### Migration Files
Located in `database/migrations/`:

1. `0001_01_01_000000_create_users_table.php` - Users table
2. `2025_04_17_103159_create_departments_table.php` - Departments table
3. `2025_04_17_103258_create_doctors_table.php` - Doctors table
4. `2025_04_17_103314_create_patients_table.php` - Patients table
5. `2025_04_17_103459_create_appointments_table.php` - Appointments table
6. `2025_04_17_103534_create_payments_table.php` - Payments table
7. `2025_04_17_103545_create_test_reports_table.php` - Test reports table
8. `2025_04_18_045303_create_permission_tables.php` - Spatie permission tables

### Key Database Relationships

```sql
-- Foreign Key Constraints
ALTER TABLE doctors ADD CONSTRAINT fk_doctors_user FOREIGN KEY (user_id) REFERENCES users(id);
ALTER TABLE doctors ADD CONSTRAINT fk_doctors_department FOREIGN KEY (department_id) REFERENCES departments(id);
ALTER TABLE patients ADD CONSTRAINT fk_patients_user FOREIGN KEY (user_id) REFERENCES users(id);
ALTER TABLE appointments ADD CONSTRAINT fk_appointments_doctor FOREIGN KEY (doctor_id) REFERENCES doctors(id);
ALTER TABLE appointments ADD CONSTRAINT fk_appointments_patient FOREIGN KEY (patient_id) REFERENCES patients(id);
ALTER TABLE appointments ADD CONSTRAINT fk_appointments_department FOREIGN KEY (department_id) REFERENCES departments(id);
ALTER TABLE payments ADD CONSTRAINT fk_payments_appointment FOREIGN KEY (appointment_id) REFERENCES appointments(id);
ALTER TABLE payments ADD CONSTRAINT fk_payments_patient FOREIGN KEY (patient_id) REFERENCES patients(id);
ALTER TABLE test_reports ADD CONSTRAINT fk_test_reports_patient FOREIGN KEY (patient_id) REFERENCES patients(id);
ALTER TABLE test_reports ADD CONSTRAINT fk_test_reports_doctor FOREIGN KEY (doctor_id) REFERENCES doctors(id);
```

## Model Relationships

### Relationship Diagram
```
User
├── hasOne Doctor
├── hasOne Patient
└── belongsToMany Role

Department
├── hasMany Doctor
└── hasMany Appointment

Doctor
├── belongsTo User
├── belongsTo Department
├── hasMany Appointment
└── hasMany TestReport

Patient
├── belongsTo User
├── hasMany Appointment
├── hasMany TestReport
└── hasMany Payment

Appointment
├── belongsTo Doctor
├── belongsTo Patient
├── belongsTo Department
├── hasOne Payment
├── belongsTo Appointment (previous)
└── hasMany Appointment (follow-ups)

Payment
├── belongsTo Appointment
└── belongsTo Patient

TestReport
├── belongsTo Patient
└── belongsTo Doctor
```

## Filament Resources

### Resource Files
Located in `app/Filament/Resources/`:

- `UserResource.php` - User management
- `DepartmentResource.php` - Department management
- `DoctorResource.php` - Doctor profiles
- `PatientResource.php` - Patient management
- `AppointmentResource.php` - Appointment scheduling
- `PaymentResource.php` - Payment tracking
- `TestReportResource.php` - Test report management
- `RoleResource.php` - Role management
- `PermissionResource.php` - Permission management

### Key Resource Features

#### Form Components
```php
// Example from UserResource
Forms\Components\TextInput::make('name')
    ->required()
    ->maxLength(255),
Forms\Components\TextInput::make('email')
    ->email()
    ->required()
    ->unique(ignoreRecord: true),
Select::make('roles')
    ->multiple()
    ->relationship('roles', 'name'),
```

#### Table Columns
```php
// Example table configuration
Tables\Columns\TextColumn::make('name')
    ->searchable()
    ->sortable(),
Tables\Columns\TextColumn::make('email')
    ->searchable()
    ->sortable(),
```

## Policies & Permissions

### Permission System
Based on Spatie Laravel Permission package with custom policies.

#### Available Permissions
For each model (User, Role, Permission, Appointment, Doctor, Patient, Department, Payment, TestReport):
- `view-any {Model}` - Can view list of records
- `view {Model}` - Can view individual record
- `create {Model}` - Can create new record
- `update {Model}` - Can modify existing record
- `delete {Model}` - Can delete record
- `restore {Model}` - Can restore soft-deleted record
- `force-delete {Model}` - Can permanently delete record

#### Role Permissions

**Admin Role**:
- All permissions for all models

**Doctor Role**:
- View permissions for all models
- Create permissions for User, Appointment, Doctor, Patient, Department, Payment, TestReport

**Patient Role**:
- View permissions for all models
- Limited create permissions

### Policy Files
Located in `app/Policies/`:
- `UserPolicy.php`
- `DepartmentPolicy.php`
- `DoctorPolicy.php`
- `PatientPolicy.php`
- `AppointmentPolicy.php`
- `PaymentPolicy.php`
- `TestReportPolicy.php`
- `RolePolicy.php`
- `PermissionPolicy.php`

## Seeders

### Seeder Files
Located in `database/seeders/`:

1. `RolesAndPermissionsSeeder.php` - Creates roles and permissions
2. `AdminUserSeeder.php` - Creates default admin user
3. `DoctorUserSeeder.php` - Creates sample doctor user
4. `PatientUserSeeder.php` - Creates sample patient user
5. `DepartmentSeeder.php` - Creates sample departments

### Default Data Created

#### Users
- Admin: admin@example.com / password
- Doctor: doctor@example.com / password
- Patient: patient@example.com / password

#### Departments
- Cardiology
- Neurology
- Orthopedics
- Pediatrics
- General Medicine

## Key Functionality

### Authentication Flow
1. User access Filament login page
2. Credentials validated against users table
3. Role-based redirects after login
4. Permission checks on resource access

### Appointment Booking
1. Select department and doctor
2. Choose available time slot
3. Enter appointment details
4. System validates conflicts
5. Appointment created with "Scheduled" status

### Payment Processing
1. Payment linked to appointment
2. Calculate totals with tax/discount
3. Handle insurance coverage
4. Generate invoice number
5. Track payment status

### Test Report Management
1. Doctor creates test report
2. Upload test file if needed
3. Mark as critical if required
4. Set follow-up requirements
5. Patient receives notification

### Widget Integration
- `StatsOverview` - Dashboard statistics
- `CalendarWidget` - Appointment calendar view

## Development Guidelines

### Adding New Models
1. Create migration file
2. Create Eloquent model with relationships
3. Create Filament resource
4. Create policy for authorization
5. Update seeders if needed
6. Add permissions to role seeder

### Extending Existing Models
1. Create new migration for schema changes
2. Update model's fillable array
3. Update Filament resource forms/tables
4. Update policies if needed
5. Update seeders for new fields

### Testing
- Use Laravel's testing framework
- Test model relationships
- Test policy permissions
- Test Filament resource functionality

## API Endpoints (Future Enhancement)

While currently focused on Filament admin panel, the system is structured to easily add API endpoints:

```php
// Example API routes (not implemented)
Route::apiResource('appointments', AppointmentController::class);
Route::apiResource('patients', PatientController::class);
Route::apiResource('doctors', DoctorController::class);
```

---

This API reference provides the foundation for understanding and extending the Hospital Management System. For implementation details, refer to the actual model and resource files in the codebase.

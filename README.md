# Hospital Management System (HMS)

A comprehensive, modern Hospital Management System built with Laravel 12 and Filament v3, designed to streamline healthcare operations and improve patient care management. This system provides a complete solution for managing hospitals, clinics, and healthcare facilities.

## 🏥 Overview

The Hospital Management System is a web-based application that digitizes and automates healthcare operations. It features role-based access control, comprehensive patient management, appointment scheduling, medical records management, and financial tracking - all wrapped in a modern, intuitive interface powered by Filament.

## ✨ Key Features

### 👥 User Management & Authentication
- **Multi-Role System**: Admin, Doctor, and Patient roles with granular permissions
- **Secure Authentication**: Laravel Sanctum-based authentication with role-based access
- **Profile Management**: Comprehensive user profile management with themes support
- **Permission-Based Access**: Spatie Permission integration for fine-grained control

### 👨‍⚕️ Doctor Management
- **Doctor Profiles**: Complete doctor information with specializations and qualifications
- **Department Assignment**: Multi-department support with specialization tracking
- **Availability Management**: Flexible scheduling with consultation hours
- **Experience Tracking**: License numbers, experience years, and consultation fees
- **Bio and Profile Pictures**: Rich doctor profiles for patient selection

### 👤 Patient Management
- **Patient Registration**: Comprehensive patient onboarding with medical history
- **Health Records**: Blood group, allergies, chronic diseases tracking
- **Emergency Contacts**: Emergency contact information management
- **Insurance Management**: Insurance provider and policy tracking
- **Physical Metrics**: Height, weight, and vital statistics tracking

### 📅 Appointment System
- **Smart Scheduling**: Online appointment booking with conflict prevention
- **Status Tracking**: Real-time appointment status updates
- **Consultation Types**: Support for both virtual and in-person consultations
- **Follow-up Management**: Automated follow-up appointment scheduling
- **Calendar Integration**: Full calendar view with appointment management

### 🏥 Department Management
- **Multi-Department Support**: Organize doctors and services by departments
- **Department Profiles**: Department descriptions and service information
- **Active Status Management**: Enable/disable departments as needed

### 📋 Medical Records & Test Reports
- **Test Management**: Comprehensive test report management system
- **Result Interpretation**: Critical result flagging and interpretation
- **Follow-up Scheduling**: Automatic follow-up based on test results
- **Medical History**: Complete patient medical history tracking

### 💰 Payment & Billing
- **Payment Tracking**: Comprehensive payment and billing management
- **Insurance Claims**: Insurance claim processing and tracking
- **Multiple Payment Methods**: Support for various payment options
- **Invoice Generation**: Automated invoice and receipt generation

### 📊 Dashboard & Analytics
- **Real-time Stats**: Live dashboard with key performance indicators
- **Calendar Widgets**: Interactive calendar for appointment management
- **Analytics**: Comprehensive reporting and analytics tools

## 🛠 Technology Stack

### Backend
- **Framework**: Laravel 12.x (PHP 8.2+)
- **Database**: MySQL/SQLite support with Eloquent ORM
- **Authentication**: Laravel Sanctum with Spatie Permission
- **Admin Panel**: Filament v3 with enhanced UI components

### Frontend
- **UI Framework**: Filament v3 (Built on Livewire & Alpine.js)
- **CSS Framework**: TailwindCSS v4
- **JavaScript**: Alpine.js, Livewire
- **Build Tool**: Vite

### Third-Party Packages
- **Role Management**: `spatie/laravel-permission`
- **Admin Panel**: `filament/filament`
- **Calendar**: `saade/filament-fullcalendar`
- **Themes**: `hasnayeen/themes`
- **Auth Enhancement**: `diogogpinto/filament-auth-ui-enhancer`

## 🏗 System Architecture

```
┌─────────────────────────────────────────────────────────┐
│                   Presentation Layer                    │
│  ┌─────────────┐  ┌─────────────┐  ┌─────────────────┐  │
│  │   Admin     │  │   Doctor    │  │     Patient     │  │
│  │  Dashboard  │  │  Dashboard  │  │   Dashboard     │  │
│  └─────────────┘  └─────────────┘  └─────────────────┘  │
└─────────────────────────────────────────────────────────┘
                            │
┌─────────────────────────────────────────────────────────┐
│                  Application Layer                      │
│  ┌─────────────┐  ┌─────────────┐  ┌─────────────────┐  │
│  │  Filament   │  │  Laravel    │  │   Livewire     │  │
│  │  Resources  │  │ Controllers │  │  Components    │  │
│  └─────────────┘  └─────────────┘  └─────────────────┘  │
└─────────────────────────────────────────────────────────┘
                            │
┌─────────────────────────────────────────────────────────┐
│                   Business Layer                        │
│  ┌─────────────┐  ┌─────────────┐  ┌─────────────────┐  │
│  │   Models    │  │  Policies   │  │   Services      │  │
│  │ (Eloquent)  │  │ (Security)  │  │  (Business)     │  │
│  └─────────────┘  └─────────────┘  └─────────────────┘  │
└─────────────────────────────────────────────────────────┘
                            │
┌─────────────────────────────────────────────────────────┐
│                    Data Layer                           │
│  ┌─────────────┐  ┌─────────────┐  ┌─────────────────┐  │
│  │   MySQL/    │  │ Migrations  │  │    Seeders      │  │
│  │   SQLite    │  │  (Schema)   │  │ (Sample Data)   │  │
│  └─────────────┘  └─────────────┘  └─────────────────┘  │
└─────────────────────────────────────────────────────────┘
```

## 🚀 Quick Start

### Prerequisites
- PHP 8.2 or higher
- Composer
- Node.js 18+ and NPM
- MySQL 8.0+ or SQLite
- Git

### Installation
```bash
# Clone the repository
git clone <repository-url>
cd Hospital-Management-System

# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install

# Environment setup
cp .env.example .env
php artisan key:generate

# Database setup
php artisan migrate
php artisan db:seed

# Build assets
npm run build

# Start development server
php artisan serve
```

### Default Login Credentials
- **Admin**: admin@example.com / password
- **Doctor**: doctor@example.com / password
- **Patient**: patient@example.com / password

## 📚 Documentation Structure

```
docs/
├── README.md                 # This file - Project overview
├── installation/             # Installation and setup guides
│   ├── requirements.md       # System requirements
│   ├── installation.md       # Step-by-step installation
│   ├── configuration.md      # Configuration options
│   └── troubleshooting.md    # Common issues and solutions
├── user-guides/              # User documentation
│   ├── admin-guide.md        # Administrator guide
│   ├── doctor-guide.md       # Doctor user guide
│   ├── patient-guide.md      # Patient user guide
│   └── workflows.md          # System workflows
├── development/              # Developer documentation
│   ├── api-reference.md      # API documentation
│   ├── database-schema.md    # Database structure
│   ├── contributing.md       # Development guidelines
│   └── architecture.md       # System architecture
└── deployment/               # Deployment guides
    ├── production.md         # Production deployment
    ├── docker.md             # Docker deployment
    └── security.md           # Security considerations
```

## 🔐 Security Features

- **Role-Based Access Control**: Granular permissions for different user types
- **Data Encryption**: Sensitive data encryption at rest
- **Secure Authentication**: Laravel's built-in authentication with enhancements
- **Input Validation**: Comprehensive form validation and sanitization
- **CSRF Protection**: Cross-site request forgery protection
- **SQL Injection Prevention**: Eloquent ORM protects against SQL injection

## 🌍 Multi-Language Support

The system supports internationalization with language files for:
- English (default)
- Arabic, German, Spanish, French, Italian
- And many more through the Filament Spatie package

## 📈 Scalability & Performance

- **Database Optimization**: Proper indexing and query optimization
- **Caching**: Built-in caching for improved performance
- **Queue System**: Background job processing for heavy operations
- **Asset Optimization**: Vite-based asset bundling and optimization

## 🤝 Contributing

We welcome contributions! Please see our [Contributing Guidelines](docs/development/contributing.md) for details on:
- Code standards and conventions
- Pull request process
- Issue reporting
- Development setup

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🆘 Support

For support and questions:
- 📧 Email: support@hms-system.com
- 📖 Documentation: [Full Documentation](docs/)
- 🐛 Issues: [GitHub Issues](https://github.com/kailashsahu08/Hospital-Manament-System/issues)
- 💬 Discussions: [GitHub Discussions](https://github.com/kailashsahu08/Hospital-Manament-System/discussions)

## 🙏 Acknowledgments

- [Laravel](https://laravel.com) - The PHP framework for web artisans
- [Filament](https://filamentphp.com) - Beautiful admin panel for Laravel
- [Spatie](https://spatie.be) - Role and permission management
- [TailwindCSS](https://tailwindcss.com) - Utility-first CSS framework
- [Heroicons](https://heroicons.com) - Beautiful hand-crafted SVG icons

---

**Built with ❤️ for better healthcare management**

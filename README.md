# Hospital Management System

A comprehensive Hospital Management System built with Laravel and Filament, designed to streamline healthcare operations and improve patient care management.

## Features

- **User Management**
  - Role-based access control (Admin, Doctor, Patient)
  - Secure authentication and authorization
  - User profile management

- **Doctor Management**
  - Doctor profiles with specialization
  - Department assignment
  - Availability scheduling
  - License and experience tracking

- **Patient Management**
  - Patient registration and profiles
  - Medical history tracking
  - Insurance information management
  - Emergency contact details

- **Appointment System**
  - Online appointment scheduling
  - Appointment status tracking
  - Virtual and in-person consultation options
  - Follow-up appointment management

- **Medical Records**
  - Test report management
  - Result interpretation
  - Critical result flagging
  - Follow-up scheduling

- **Department Management**
  - Multiple department support
  - Department-wise doctor assignment
  - Specialization tracking

- **Payment Management**
  - Payment tracking
  - Insurance claim processing
  - Multiple payment methods
  - Invoice generation

## Requirements

- PHP >= 8.1
- Composer
- MySQL >= 5.7
- Node.js & NPM
- Git

## Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/yourusername/hospital-management-system.git
   cd hospital-management-system
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install NPM dependencies**
   ```bash
   npm install
   ```

4. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configure your database**
   Edit the `.env` file and set your database credentials:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database_name
   DB_USERNAME=your_database_username
   DB_PASSWORD=your_database_password
   ```

6. **Run database migrations and seeders**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

7. **Build assets**
   ```bash
   npm run build
   ```

8. **Start the development server**
   ```bash
   php artisan serve
   ```

## Default Login Credentials

After running the seeders, you can log in with these default credentials:

- **Admin**
  - Email: admin@example.com
  - Password: password

- **Doctor**
  - Email: doctor@example.com
  - Password: password

- **Patient**
  - Email: patient@example.com
  - Password: password

## Directory Structure

```
├── app/
│   ├── Filament/           # Filament admin panel resources
│   ├── Models/             # Eloquent models
│   ├── Policies/           # Authorization policies
│   └── Providers/          # Service providers
├── database/
│   ├── migrations/         # Database migrations
│   └── seeders/           # Database seeders
├── public/
│   ├── css/               # Compiled CSS
│   └── js/                # Compiled JavaScript
└── resources/
    ├── css/               # Source CSS
    └── js/                # Source JavaScript
```

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## Security

If you discover any security-related issues, please email [your-email@example.com](mailto:your-email@example.com) instead of using the issue tracker.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Acknowledgments

- [Laravel](https://laravel.com)
- [Filament](https://filamentphp.com)
- [Spatie Permission](https://github.com/spatie/laravel-permission)
- [Heroicons](https://heroicons.com)

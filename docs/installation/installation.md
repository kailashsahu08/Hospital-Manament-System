# Installation Guide

This guide will walk you through the complete installation process for the Hospital Management System. Follow each step carefully to ensure a successful setup.

## 📋 Prerequisites

Before installing the HMS, ensure your system meets the following requirements:

### System Requirements
- **Operating System**: Linux (Ubuntu 20.04+), macOS (10.15+), or Windows 10+
- **PHP**: Version 8.2 or higher with required extensions
- **Web Server**: Apache 2.4+ or Nginx 1.18+
- **Database**: MySQL 8.0+ or MariaDB 10.4+ or SQLite 3.8+
- **Memory**: Minimum 2GB RAM (4GB recommended)
- **Storage**: At least 1GB free disk space

### Required PHP Extensions
```bash
# Check if extensions are installed
php -m | grep -E "(bcmath|ctype|curl|dom|fileinfo|gd|json|mbstring|openssl|pcre|pdo|tokenizer|xml|zip)"
```

Required extensions:
- bcmath
- ctype
- curl
- dom
- fileinfo
- gd
- json
- mbstring
- openssl
- pcre
- pdo (with pdo_mysql or pdo_sqlite)
- tokenizer
- xml
- zip

### Software Dependencies
- **Composer**: PHP dependency manager (2.0+)
- **Node.js**: JavaScript runtime (18.0+)
- **NPM**: Node package manager (8.0+)
- **Git**: Version control system

## 🔧 Step 1: Install System Dependencies

### Ubuntu/Debian
```bash
# Update package list
sudo apt update

# Install PHP and extensions
sudo apt install php8.2 php8.2-cli php8.2-fpm php8.2-mysql php8.2-sqlite3 \
    php8.2-zip php8.2-gd php8.2-mbstring php8.2-curl php8.2-xml \
    php8.2-bcmath php8.2-json php8.2-tokenizer

# Install MySQL (optional if using SQLite)
sudo apt install mysql-server

# Install Node.js and NPM
curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
sudo apt install nodejs

# Install Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
```

### macOS (using Homebrew)
```bash
# Install PHP
brew install php@8.2

# Install MySQL (optional)
brew install mysql

# Install Node.js
brew install node

# Install Composer
brew install composer
```

### Windows
1. Download and install [XAMPP](https://www.apachefriends.org/) or [WAMP](https://www.wampserver.com/)
2. Download and install [Node.js](https://nodejs.org/)
3. Download and install [Composer](https://getcomposer.org/download/)
4. Download and install [Git](https://git-scm.com/download/win)

## 📥 Step 2: Clone the Repository

```bash
# Clone the repository
git clone https://github.com/your-username/hospital-management-system.git

# Navigate to project directory
cd hospital-management-system

# Check if clone was successful
ls -la
```

## 📦 Step 3: Install Dependencies

### Install PHP Dependencies
```bash
# Install Composer dependencies
composer install --no-dev --optimize-autoloader

# If you encounter memory issues, increase memory limit
php -d memory_limit=2G /usr/local/bin/composer install --no-dev --optimize-autoloader
```

### Install Node.js Dependencies
```bash
# Install NPM packages
npm install

# For production, you can use:
npm ci --production
```

## ⚙️ Step 4: Environment Configuration

### Copy Environment File
```bash
# Copy the example environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### Configure Database

#### Option 1: SQLite (Recommended for Development)
```bash
# Create SQLite database file
touch database/database.sqlite
```

Edit `.env` file:
```env
DB_CONNECTION=sqlite
# Remove or comment out other DB_ variables
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=laravel
# DB_USERNAME=root
# DB_PASSWORD=
```

#### Option 2: MySQL
```bash
# Create database
mysql -u root -p
CREATE DATABASE hospital_management;
CREATE USER 'hms_user'@'localhost' IDENTIFIED BY 'your_password';
GRANT ALL PRIVILEGES ON hospital_management.* TO 'hms_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

Edit `.env` file:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hospital_management
DB_USERNAME=hms_user
DB_PASSWORD=your_password
```

### Configure Application Settings
Edit your `.env` file with appropriate values:

```env
APP_NAME="Hospital Management System"
APP_ENV=local
APP_KEY=base64:your_generated_key_here
APP_DEBUG=true
APP_URL=http://localhost:8000

# Database Configuration (as configured above)
DB_CONNECTION=sqlite

# Mail Configuration (for notifications)
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-email@example.com
MAIL_PASSWORD=your-email-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@yourhospital.com"
MAIL_FROM_NAME="${APP_NAME}"

# Cache Configuration
CACHE_STORE=file
SESSION_DRIVER=file
QUEUE_CONNECTION=database

# File Storage
FILESYSTEM_DISK=local
```

## 🗄️ Step 5: Database Setup

### Run Migrations
```bash
# Run database migrations
php artisan migrate

# If you encounter issues, you can reset and re-run
php artisan migrate:fresh
```

### Seed Sample Data
```bash
# Run all seeders to populate sample data
php artisan db:seed

# Or run specific seeders
php artisan db:seed --class=RolesAndPermissionsSeeder
php artisan db:seed --class=AdminUserSeeder
php artisan db:seed --class=DepartmentSeeder
```

### Create Storage Link
```bash
# Create symbolic link for file storage
php artisan storage:link
```

## 🎨 Step 6: Build Frontend Assets

### Development Build
```bash
# Build assets for development
npm run dev
```

### Production Build
```bash
# Build and optimize assets for production
npm run build
```

## 🚀 Step 7: Start the Application

### Development Server
```bash
# Start Laravel development server
php artisan serve

# The application will be available at http://127.0.0.1:8000
```

### With Live Reload (Development)
```bash
# Start with live reload and queue processing
npm run dev
composer run dev
```

## 🔐 Step 8: Initial Login

After successful installation, you can log in using these default credentials:

### Administrator
- **Email**: admin@example.com
- **Password**: password
- **Role**: Admin (Full system access)

### Doctor
- **Email**: doctor@example.com
- **Password**: password
- **Role**: Doctor (Medical staff access)

### Patient
- **Email**: patient@example.com
- **Password**: password
- **Role**: Patient (Patient portal access)

**⚠️ Important**: Change these default passwords immediately after first login!

## 🔧 Step 9: Post-Installation Configuration

### File Permissions (Linux/macOS)
```bash
# Set proper permissions
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache

# For development environment
chmod -R 775 storage bootstrap/cache
```

### Configure Cron Jobs (Production)
```bash
# Add to crontab for scheduled tasks
crontab -e

# Add this line:
* * * * * cd /path/to/your/project && php artisan schedule:run >> /dev/null 2>&1
```

### Configure Queue Workers (Production)
```bash
# Install supervisor (Ubuntu)
sudo apt install supervisor

# Create supervisor config
sudo nano /etc/supervisor/conf.d/hms-worker.conf
```

Supervisor config content:
```ini
[program:hms-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /path/to/your/project/artisan queue:work --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/path/to/your/project/storage/logs/worker.log
stopwaitsecs=3600
```

```bash
# Start supervisor
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start hms-worker:*
```

## ✅ Step 10: Verify Installation

### Health Check
```bash
# Check application status
php artisan route:list
php artisan config:cache
php artisan view:cache
```

### Test Database Connection
```bash
# Test database connection
php artisan tinker
>>> DB::connection()->getPdo();
>>> exit
```

### Access the Application
1. Open your web browser
2. Navigate to `http://127.0.0.1:8000` (or your configured URL)
3. You should see the HMS login page
4. Log in with the default admin credentials
5. Verify all main features are accessible

## 🐛 Common Installation Issues

### Composer Memory Issues
```bash
# Increase PHP memory limit temporarily
php -d memory_limit=2G composer install
```

### Permission Errors
```bash
# Fix storage and cache permissions
sudo chmod -R 775 storage bootstrap/cache
sudo chown -R $USER:www-data storage bootstrap/cache
```

### Database Connection Errors
- Verify database credentials in `.env`
- Ensure database server is running
- Check firewall settings

### NPM Build Errors
```bash
# Clear NPM cache
npm cache clean --force
rm -rf node_modules package-lock.json
npm install
```

## 🔄 Update Process

### Updating the Application
```bash
# Pull latest changes
git pull origin main

# Update dependencies
composer install --no-dev --optimize-autoloader
npm install

# Update database
php artisan migrate

# Rebuild assets
npm run build

# Clear caches
php artisan config:cache
php artisan view:cache
php artisan route:cache
```

## 🆘 Getting Help

If you encounter issues during installation:

1. Check the [Troubleshooting Guide](troubleshooting.md)
2. Review Laravel logs: `storage/logs/laravel.log`
3. Check web server logs
4. Verify system requirements
5. Consult the [FAQ](../user-guides/faq.md)

For additional support:
- 📧 Email: support@hms-system.com
- 🐛 GitHub Issues: [Report Issues](https://github.com/your-repo/issues)
- 📖 Documentation: [Full Documentation](../README.md)

---

**Next Steps**: After successful installation, proceed to the [Configuration Guide](configuration.md) for advanced setup options.

# Troubleshooting Guide & FAQ

This guide provides solutions to common issues you may encounter when installing, configuring, or using the Hospital Management System.

## Table of Contents

1. [Installation Issues](#installation-issues)
2. [Database Issues](#database-issues)
3. [Web Server Issues](#web-server-issues)
4. [Permission Issues](#permission-issues)
5. [Performance Issues](#performance-issues)
6. [Authentication Issues](#authentication-issues)
7. [Filament Issues](#filament-issues)
8. [Email Issues](#email-issues)
9. [File Upload Issues](#file-upload-issues)
10. [General FAQ](#general-faq)

## Installation Issues

### PHP Extension Missing

**Problem**: Error during installation about missing PHP extensions.

**Solution**:
```bash
# Check which extensions are loaded
php -m

# Install missing extensions (Ubuntu/Debian)
sudo apt install php8.2-{extension-name}

# Example for common extensions
sudo apt install php8.2-curl php8.2-gd php8.2-mbstring php8.2-xml php8.2-zip

# Restart web server
sudo systemctl restart nginx
sudo systemctl restart php8.2-fpm
```

### Composer Memory Issues

**Problem**: Composer runs out of memory during installation.

**Solution**:
```bash
# Increase memory limit temporarily
php -d memory_limit=2G composer install

# Or set unlimited memory
php -d memory_limit=-1 composer install

# Make permanent by editing php.ini
sudo nano /etc/php/8.2/cli/php.ini
# Set: memory_limit = 2G
```

### Node.js/NPM Issues

**Problem**: NPM installation fails or Node.js version conflicts.

**Solution**:
```bash
# Check Node.js version
node --version
npm --version

# Update Node.js using nvm
curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.0/install.sh | bash
source ~/.bashrc
nvm install 18
nvm use 18

# Clear NPM cache and reinstall
npm cache clean --force
rm -rf node_modules package-lock.json
npm install
```

### Application Key Generation Fails

**Problem**: `php artisan key:generate` fails.

**Solution**:
```bash
# Check if .env file exists
ls -la .env

# Copy from example if missing
cp .env.example .env

# Generate key manually if artisan fails
php -r "echo 'APP_KEY=base64:'.base64_encode(random_bytes(32)).PHP_EOL;"

# Add the generated key to your .env file
```

## Database Issues

### Database Connection Failed

**Problem**: Cannot connect to database.

**Solution**:

1. **Check database credentials in `.env`**:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hospital_management
DB_USERNAME=hms_user
DB_PASSWORD=your_password
```

2. **Test database connection**:
```bash
# Test MySQL connection
mysql -h 127.0.0.1 -u hms_user -p hospital_management

# Test from Laravel
php artisan tinker
>>> DB::connection()->getPdo();
```

3. **Check MySQL service**:
```bash
sudo systemctl status mysql
sudo systemctl start mysql

# Check if MySQL is listening on correct port
sudo netstat -tlnp | grep mysql
```

### Migration Fails

**Problem**: Database migration fails with errors.

**Solution**:

1. **Check database permissions**:
```sql
SHOW GRANTS FOR 'hms_user'@'localhost';
```

2. **Reset migrations**:
```bash
# Warning: This will drop all tables
php artisan migrate:fresh

# Or rollback and retry
php artisan migrate:rollback
php artisan migrate
```

3. **Check for table conflicts**:
```sql
SHOW TABLES;
DROP TABLE IF EXISTS conflicting_table;
```

### Seeder Fails

**Problem**: Database seeder fails to run.

**Solution**:
```bash
# Check specific seeder
php artisan db:seed --class=RolesAndPermissionsSeeder

# Clear cache and retry
php artisan config:clear
php artisan cache:clear
php artisan db:seed

# Check for duplicate data
php artisan tinker
>>> \App\Models\User::where('email', 'admin@example.com')->count();
```

## Web Server Issues

### 500 Internal Server Error

**Problem**: Website shows 500 error.

**Solution**:

1. **Check error logs**:
```bash
# Laravel logs
tail -f storage/logs/laravel.log

# Nginx logs
sudo tail -f /var/log/nginx/error.log

# PHP-FPM logs
sudo tail -f /var/log/php8.2-fpm.log
```

2. **Common fixes**:
```bash
# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Regenerate caches
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

3. **Check file permissions**:
```bash
sudo chown -R www-data:www-data /var/www/hms
sudo chmod -R 755 /var/www/hms
sudo chmod -R 775 /var/www/hms/storage
sudo chmod -R 775 /var/www/hms/bootstrap/cache
```

### 404 Not Found for Admin Panel

**Problem**: `/admin` URL returns 404 error.

**Solution**:

1. **Check Filament installation**:
```bash
php artisan filament:install --panels
```

2. **Verify routes**:
```bash
php artisan route:list | grep admin
```

3. **Check Nginx configuration**:
```nginx
location / {
    try_files $uri $uri/ /index.php?$query_string;
}
```

### PHP-FPM Not Working

**Problem**: PHP files not processing, showing as plain text.

**Solution**:

1. **Check PHP-FPM status**:
```bash
sudo systemctl status php8.2-fpm
sudo systemctl start php8.2-fpm
```

2. **Verify Nginx PHP configuration**:
```nginx
location ~ \.php$ {
    fastcgi_pass unix:/run/php/php8.2-fpm.sock;
    fastcgi_index index.php;
    fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
    include fastcgi_params;
}
```

3. **Test PHP processing**:
```bash
# Create test file
echo "<?php phpinfo(); ?>" | sudo tee /var/www/hms/public/info.php
# Visit http://yourdomain.com/info.php
# Remove after testing
sudo rm /var/www/hms/public/info.php
```

## Permission Issues

### Storage Permission Denied

**Problem**: Cannot write to storage directory.

**Solution**:
```bash
# Fix ownership
sudo chown -R www-data:www-data /var/www/hms/storage
sudo chown -R www-data:www-data /var/www/hms/bootstrap/cache

# Fix permissions
sudo chmod -R 775 /var/www/hms/storage
sudo chmod -R 775 /var/www/hms/bootstrap/cache

# For development (less secure)
sudo chmod -R 777 /var/www/hms/storage
sudo chmod -R 777 /var/www/hms/bootstrap/cache
```

### Log File Permission Denied

**Problem**: Laravel cannot write to log files.

**Solution**:
```bash
# Create log directory if missing
sudo mkdir -p /var/www/hms/storage/logs

# Fix permissions
sudo chown -R www-data:www-data /var/www/hms/storage/logs
sudo chmod -R 775 /var/www/hms/storage/logs

# Clear log files if needed
sudo truncate -s 0 /var/www/hms/storage/logs/laravel.log
```

### File Upload Permission Issues

**Problem**: Cannot upload files through the application.

**Solution**:
```bash
# Check upload directory permissions
sudo chown -R www-data:www-data /var/www/hms/storage/app
sudo chmod -R 775 /var/www/hms/storage/app

# Create symbolic link if missing
php artisan storage:link

# Check PHP upload settings
php -i | grep upload
```

## Performance Issues

### Slow Page Load Times

**Problem**: Application loads slowly.

**Solution**:

1. **Enable caching**:
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

2. **Enable OpCache** in `php.ini`:
```ini
opcache.enable=1
opcache.memory_consumption=256
opcache.max_accelerated_files=10000
opcache.revalidate_freq=2
```

3. **Use Redis for sessions and cache**:
```env
CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis
```

4. **Optimize database queries**:
```bash
# Enable query log to identify slow queries
php artisan tinker
>>> DB::enableQueryLog();
>>> # Perform your operations
>>> dd(DB::getQueryLog());
```

### High Memory Usage

**Problem**: PHP processes using too much memory.

**Solution**:

1. **Increase PHP memory limit**:
```ini
; In php.ini
memory_limit = 256M
```

2. **Check for memory leaks**:
```bash
# Monitor memory usage
htop

# Check specific PHP process
ps aux | grep php-fpm
```

3. **Optimize Eloquent queries**:
```php
// Use eager loading to avoid N+1 queries
$appointments = Appointment::with(['doctor', 'patient', 'department'])->get();

// Use select to limit columns
$appointments = Appointment::select(['id', 'doctor_id', 'patient_id'])->get();
```

## Authentication Issues

### Cannot Login with Default Credentials

**Problem**: Default admin credentials don't work.

**Solution**:

1. **Check if admin user exists**:
```bash
php artisan tinker
>>> \App\Models\User::where('email', 'admin@example.com')->first();
```

2. **Create admin user manually**:
```bash
php artisan tinker
>>> $user = \App\Models\User::create([
...     'name' => 'Administrator',
...     'email' => 'admin@example.com',
...     'password' => bcrypt('password')
... ]);
>>> $user->assignRole('admin');
```

3. **Reset password**:
```bash
php artisan tinker
>>> $user = \App\Models\User::where('email', 'admin@example.com')->first();
>>> $user->password = bcrypt('newpassword');
>>> $user->save();
```

### Session Expired Issues

**Problem**: Users keep getting logged out.

**Solution**:

1. **Check session configuration** in `.env`:
```env
SESSION_DRIVER=file
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null
```

2. **For HTTPS sites**:
```env
SESSION_SECURE_COOKIE=true
```

3. **Clear session files**:
```bash
rm -rf /var/www/hms/storage/framework/sessions/*
```

### Permission Denied Errors

**Problem**: Users can't access certain pages/features.

**Solution**:

1. **Check user roles**:
```bash
php artisan tinker
>>> $user = \App\Models\User::find(1);
>>> $user->roles;
>>> $user->permissions;
```

2. **Re-run permissions seeder**:
```bash
php artisan db:seed --class=RolesAndPermissionsSeeder
```

3. **Clear permission cache**:
```bash
php artisan permission:cache-reset
```

## Filament Issues

### Filament Admin Panel Not Accessible

**Problem**: `/admin` route returns 404 or error.

**Solution**:

1. **Install Filament panels**:
```bash
php artisan filament:install --panels
```

2. **Check panel configuration**:
```bash
# Check if AdminPanelProvider is registered
cat app/Providers/Filament/AdminPanelProvider.php
```

3. **Clear caches**:
```bash
php artisan filament:clear-cached-components
php artisan route:clear
```

### Filament Resources Not Showing

**Problem**: Created resources don't appear in navigation.

**Solution**:

1. **Check resource registration**:
```php
// In AdminPanelProvider
public function panel(Panel $panel): Panel
{
    return $panel
        ->resources([
            \App\Filament\Resources\UserResource::class,
            // Add your resources here
        ]);
}
```

2. **Check navigation permissions**:
```php
// In Resource
public static function canViewAny(): bool
{
    return auth()->user()->can('view-any User');
}
```

### Filament Form Validation Issues

**Problem**: Form validation not working correctly.

**Solution**:

1. **Check validation rules**:
```php
TextInput::make('email')
    ->email()
    ->required()
    ->unique(ignoreRecord: true)
```

2. **Clear form cache**:
```bash
php artisan filament:clear-cached-components
```

## Email Issues

### Email Not Sending

**Problem**: System emails are not being sent.

**Solution**:

1. **Check email configuration** in `.env`:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@yourdomain.com"
MAIL_FROM_NAME="${APP_NAME}"
```

2. **Test email configuration**:
```bash
php artisan tinker
>>> Mail::raw('Test email', function ($message) {
...     $message->to('test@example.com')->subject('Test');
... });
```

3. **Check mail logs**:
```bash
# If using log driver
tail -f storage/logs/laravel.log | grep mail

# Check system mail logs
sudo tail -f /var/log/mail.log
```

### Gmail SMTP Issues

**Problem**: Cannot send emails through Gmail SMTP.

**Solution**:

1. **Enable 2-factor authentication** on Gmail
2. **Generate app-specific password**
3. **Use app password in `.env`**:
```env
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-16-character-app-password
```

## File Upload Issues

### File Upload Size Limit

**Problem**: Cannot upload large files.

**Solution**:

1. **Increase PHP limits** in `php.ini`:
```ini
upload_max_filesize = 100M
post_max_size = 100M
max_file_uploads = 20
max_execution_time = 300
```

2. **Increase Nginx limits**:
```nginx
client_max_body_size 100M;
```

3. **Restart services**:
```bash
sudo systemctl restart php8.2-fpm
sudo systemctl restart nginx
```

### File Upload Permission Issues

**Problem**: Uploaded files cannot be accessed.

**Solution**:
```bash
# Check storage directory permissions
sudo chown -R www-data:www-data /var/www/hms/storage/app
sudo chmod -R 775 /var/www/hms/storage/app

# Create storage link
php artisan storage:link

# Check if link exists
ls -la /var/www/hms/public/storage
```

## General FAQ

### Q: How do I reset the system to default state?

**A**: 
```bash
# Backup your data first!
php artisan migrate:fresh --seed

# This will:
# - Drop all tables
# - Run all migrations
# - Run all seeders
# - Recreate default users and permissions
```

### Q: How do I change the default admin password?

**A**:
```bash
php artisan tinker
>>> $admin = \App\Models\User::where('email', 'admin@example.com')->first();
>>> $admin->password = bcrypt('your_new_password');
>>> $admin->save();
```

### Q: How do I backup the system?

**A**:
```bash
# Database backup
mysqldump -u username -p database_name > backup.sql

# File backup
tar -czf hms-backup.tar.gz /var/www/hms/storage

# Automated backup script (see deployment documentation)
```

### Q: How do I update the system?

**A**:
```bash
# Pull latest code
git pull origin main

# Update dependencies
composer install --no-dev --optimize-autoloader
npm ci --production
npm run build

# Run migrations
php artisan migrate --force

# Clear and rebuild caches
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Q: How do I enable debug mode safely?

**A**:
Never enable debug mode in production. For development:
```env
APP_DEBUG=true
APP_ENV=local
```

For production debugging, check logs instead:
```bash
tail -f storage/logs/laravel.log
```

### Q: How do I change the application URL?

**A**:
1. Update `.env`:
```env
APP_URL=https://your-new-domain.com
```

2. Clear caches:
```bash
php artisan config:cache
```

3. Update web server configuration

### Q: How do I add a new language?

**A**:
1. Create language files in `lang/` directory
2. Update Filament configuration
3. Add language to available locales

### Q: System is slow, what should I check?

**A**:
1. Enable caching (config, routes, views)
2. Check database indexes
3. Monitor server resources (CPU, RAM, disk I/O)
4. Enable OpCache
5. Use Redis for sessions and cache
6. Check for N+1 queries in code

### Q: How do I secure the system for production?

**A**:
1. Set `APP_DEBUG=false`
2. Use HTTPS with valid SSL certificate
3. Configure firewall (UFW/iptables)
4. Set proper file permissions
5. Regular security updates
6. Configure fail2ban
7. Use strong passwords
8. Regular backups

### Q: Database is getting large, how to optimize?

**A**:
1. Archive old data
2. Add database indexes for frequently queried columns
3. Optimize database tables: `ANALYZE TABLE` and `OPTIMIZE TABLE`
4. Review slow query log
5. Consider database partitioning for large tables

## Getting Additional Help

If you can't find a solution here:

1. **Check Laravel Logs**: `storage/logs/laravel.log`
2. **Check Web Server Logs**: `/var/log/nginx/error.log`
3. **Search GitHub Issues**: Look for similar problems
4. **Community Forums**: Laravel and Filament communities
5. **Documentation**: Review official documentation
6. **Contact Support**: reach out to the development team

### When Reporting Issues

Please include:
- **System Information**: PHP version, database version, OS
- **Error Messages**: Complete error messages from logs
- **Steps to Reproduce**: Detailed steps to reproduce the issue
- **Expected vs Actual Behavior**: What should happen vs what happens
- **Screenshots**: If applicable
- **Configuration**: Relevant configuration details (without sensitive data)

---

**Remember**: Always backup your data before making system changes, especially in production environments!

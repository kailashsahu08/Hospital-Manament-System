# Production Deployment Guide

This guide covers deploying the Hospital Management System to a production environment with best practices for security, performance, and reliability.

## Table of Contents

1. [Pre-Deployment Checklist](#pre-deployment-checklist)
2. [Server Requirements](#server-requirements)
3. [Environment Setup](#environment-setup)
4. [Database Configuration](#database-configuration)
5. [Web Server Configuration](#web-server-configuration)
6. [Security Configuration](#security-configuration)
7. [Performance Optimization](#performance-optimization)
8. [Monitoring and Logging](#monitoring-and-logging)
9. [Backup and Recovery](#backup-and-recovery)
10. [SSL/TLS Configuration](#ssltls-configuration)
11. [Post-Deployment Tasks](#post-deployment-tasks)

## Pre-Deployment Checklist

Before deploying to production, ensure you have:

### ✅ Infrastructure Ready
- [ ] Production server provisioned
- [ ] Domain name configured
- [ ] SSL certificate obtained
- [ ] Database server setup
- [ ] Backup systems configured
- [ ] Monitoring tools installed

### ✅ Security Measures
- [ ] Firewall configured
- [ ] SSH keys generated
- [ ] Database users created with limited privileges
- [ ] Environment variables secured
- [ ] Security headers configured

### ✅ Application Ready
- [ ] Code tested thoroughly
- [ ] Environment configuration prepared
- [ ] Assets optimized and built
- [ ] Database migrations tested
- [ ] Seeders prepared for production data

## Server Requirements

### Recommended Production Specifications

#### Web Server
- **CPU**: 4+ cores (2.0GHz+)
- **RAM**: 8GB minimum (16GB recommended)
- **Storage**: 100GB SSD minimum
- **OS**: Ubuntu 22.04 LTS or CentOS 8+

#### Database Server
- **CPU**: 4+ cores (2.5GHz+)
- **RAM**: 16GB minimum (32GB recommended)
- **Storage**: 500GB SSD with RAID 1/10
- **OS**: Ubuntu 22.04 LTS or CentOS 8+

#### Load Balancer (if needed)
- **CPU**: 2+ cores
- **RAM**: 4GB minimum
- **Storage**: 20GB SSD

### Software Requirements
- **PHP**: 8.2 or higher with required extensions
- **Web Server**: Nginx 1.20+ or Apache 2.4+
- **Database**: MySQL 8.0+ or MariaDB 10.6+
- **Cache**: Redis 6.0+ (recommended)
- **Queue**: Redis or database driver
- **Process Monitor**: Supervisor

## Environment Setup

### 1. System Updates and Dependencies

```bash
# Update system packages
sudo apt update && sudo apt upgrade -y

# Install essential packages
sudo apt install -y software-properties-common curl wget git unzip

# Add PHP repository
sudo add-apt-repository ppa:ondrej/php -y
sudo apt update

# Install PHP and extensions
sudo apt install -y php8.2 php8.2-fpm php8.2-cli php8.2-mysql \
    php8.2-redis php8.2-zip php8.2-gd php8.2-mbstring \
    php8.2-curl php8.2-xml php8.2-bcmath php8.2-json \
    php8.2-tokenizer php8.2-intl
```

### 2. Install and Configure MySQL

```bash
# Install MySQL
sudo apt install -y mysql-server

# Secure MySQL installation
sudo mysql_secure_installation

# Create database and user
sudo mysql -u root -p
```

```sql
CREATE DATABASE hospital_management_prod CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'hms_prod'@'localhost' IDENTIFIED BY 'secure_password_here';
GRANT ALL PRIVILEGES ON hospital_management_prod.* TO 'hms_prod'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

### 3. Install Redis

```bash
# Install Redis
sudo apt install -y redis-server

# Configure Redis
sudo systemctl enable redis-server
sudo systemctl start redis-server

# Test Redis
redis-cli ping
```

### 4. Install and Configure Nginx

```bash
# Install Nginx
sudo apt install -y nginx

# Enable and start Nginx
sudo systemctl enable nginx
sudo systemctl start nginx
```

## Database Configuration

### Production MySQL Configuration

Edit `/etc/mysql/mysql.conf.d/mysqld.cnf`:

```ini
[mysqld]
# Basic Configuration
bind-address = 127.0.0.1
port = 3306
datadir = /var/lib/mysql
socket = /var/run/mysqld/mysqld.sock

# Performance Tuning
innodb_buffer_pool_size = 4G  # 50-70% of available RAM
innodb_log_file_size = 512M
innodb_flush_log_at_trx_commit = 2
innodb_file_per_table = 1

# Connection Settings
max_connections = 200
wait_timeout = 300
interactive_timeout = 300

# Security
local_infile = 0
skip_show_database

# Logging
general_log = 0
slow_query_log = 1
slow_query_log_file = /var/log/mysql/slow.log
long_query_time = 2

# Binary Logging for Backups
log_bin = /var/log/mysql/mysql-bin.log
binlog_format = ROW
expire_logs_days = 7
```

Restart MySQL:
```bash
sudo systemctl restart mysql
```

## Web Server Configuration

### Nginx Configuration

Create `/etc/nginx/sites-available/hms`:

```nginx
server {
    listen 80;
    server_name your-domain.com www.your-domain.com;
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl http2;
    server_name your-domain.com www.your-domain.com;
    
    root /var/www/hms/public;
    index index.php index.html;
    
    # SSL Configuration
    ssl_certificate /path/to/ssl/cert.pem;
    ssl_certificate_key /path/to/ssl/private.key;
    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_ciphers ECDHE-RSA-AES256-GCM-SHA512:DHE-RSA-AES256-GCM-SHA512:ECDHE-RSA-AES256-GCM-SHA384:DHE-RSA-AES256-GCM-SHA384;
    ssl_prefer_server_ciphers off;
    ssl_session_cache shared:SSL:10m;
    ssl_session_timeout 10m;
    
    # Security Headers
    add_header X-Content-Type-Options nosniff;
    add_header X-Frame-Options DENY;
    add_header X-XSS-Protection "1; mode=block";
    add_header Strict-Transport-Security "max-age=31536000; includeSubdomains";
    add_header Content-Security-Policy "default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval'; style-src 'self' 'unsafe-inline';";
    
    # Gzip Compression
    gzip on;
    gzip_vary on;
    gzip_min_length 10240;
    gzip_proxied expired no-cache no-store private must-revalidate max-age=0;
    gzip_types text/plain text/css text/xml text/javascript application/javascript application/xml+rss application/json;
    
    # Client Upload Limits
    client_max_body_size 100M;
    
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location ~ \.php$ {
        fastcgi_pass unix:/run/php/php8.2-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
        
        # Security
        fastcgi_hide_header X-Powered-By;
        fastcgi_read_timeout 300;
    }
    
    # Deny access to sensitive files
    location ~ /\.(env|git) {
        deny all;
        return 404;
    }
    
    location ~ /(bootstrap|storage|database|tests|vendor)/ {
        deny all;
        return 404;
    }
    
    # Static file caching
    location ~* \.(css|js|png|jpg|jpeg|gif|ico|svg|woff|woff2|ttf|eot)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
    }
    
    # Error and Access Logs
    access_log /var/log/nginx/hms-access.log;
    error_log /var/log/nginx/hms-error.log;
}
```

Enable the site:
```bash
sudo ln -s /etc/nginx/sites-available/hms /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```

### PHP-FPM Configuration

Edit `/etc/php/8.2/fpm/pool.d/www.conf`:

```ini
[www]
user = www-data
group = www-data
listen = /run/php/php8.2-fpm.sock
listen.owner = www-data
listen.group = www-data
listen.mode = 0660

# Process Management
pm = dynamic
pm.max_children = 50
pm.start_servers = 10
pm.min_spare_servers = 5
pm.max_spare_servers = 20
pm.max_requests = 1000

# Security
security.limit_extensions = .php

# Performance
request_slowlog_timeout = 10s
slowlog = /var/log/php8.2-fpm-slow.log
```

Edit `/etc/php/8.2/fpm/php.ini`:

```ini
; Memory Settings
memory_limit = 256M
max_execution_time = 300
max_input_time = 300

; File Upload Settings
upload_max_filesize = 100M
post_max_size = 100M
max_file_uploads = 20

; Error Reporting (Production)
display_errors = Off
log_errors = On
error_log = /var/log/php_errors.log

; Security Settings
expose_php = Off
allow_url_fopen = Off
allow_url_include = Off

; Session Security
session.cookie_httponly = 1
session.cookie_secure = 1
session.use_only_cookies = 1

; OpCache Configuration
opcache.enable=1
opcache.memory_consumption=256
opcache.interned_strings_buffer=8
opcache.max_accelerated_files=10000
opcache.revalidate_freq=2
opcache.fast_shutdown=1
```

Restart PHP-FPM:
```bash
sudo systemctl restart php8.2-fpm
```

## Application Deployment

### 1. Deploy Application Code

```bash
# Create application directory
sudo mkdir -p /var/www/hms
cd /var/www

# Clone repository (or upload files)
sudo git clone https://github.com/your-repo/hospital-management-system.git hms
cd hms

# Set proper ownership
sudo chown -R www-data:www-data /var/www/hms
sudo chmod -R 755 /var/www/hms
sudo chmod -R 775 /var/www/hms/storage
sudo chmod -R 775 /var/www/hms/bootstrap/cache
```

### 2. Install Dependencies

```bash
# Install Composer dependencies
sudo -u www-data composer install --no-dev --optimize-autoloader --no-interaction

# Install Node.js and NPM
curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
sudo apt-get install -y nodejs

# Install NPM dependencies and build assets
sudo -u www-data npm ci --production
sudo -u www-data npm run build
```

### 3. Environment Configuration

```bash
# Copy environment file
sudo -u www-data cp .env.example .env

# Generate application key
sudo -u www-data php artisan key:generate
```

Edit `.env` for production:

```env
APP_NAME="Hospital Management System"
APP_ENV=production
APP_KEY=base64:your_generated_key_here
APP_DEBUG=false
APP_URL=https://your-domain.com

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hospital_management_prod
DB_USERNAME=hms_prod
DB_PASSWORD=your_secure_database_password

BROADCAST_DRIVER=redis
CACHE_DRIVER=redis
FILESYSTEM_DISK=local
QUEUE_CONNECTION=redis
SESSION_DRIVER=redis

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=your-smtp-server.com
MAIL_PORT=587
MAIL_USERNAME=your-email@domain.com
MAIL_PASSWORD=your-email-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@your-domain.com"
MAIL_FROM_NAME="${APP_NAME}"

# Additional Production Settings
SESSION_LIFETIME=120
SESSION_ENCRYPT=true
SESSION_SECURE_COOKIE=true
SANCTUM_STATEFUL_DOMAINS=your-domain.com
```

### 4. Database Setup

```bash
# Run migrations
sudo -u www-data php artisan migrate --force

# Run seeders (only for initial deployment)
sudo -u www-data php artisan db:seed --force

# Create storage link
sudo -u www-data php artisan storage:link
```

### 5. Cache Optimization

```bash
# Clear and cache configurations
sudo -u www-data php artisan config:cache
sudo -u www-data php artisan route:cache
sudo -u www-data php artisan view:cache

# Cache Filament components
sudo -u www-data php artisan filament:cache-components
```

## Security Configuration

### 1. Firewall Configuration

```bash
# Install and configure UFW
sudo ufw --force enable
sudo ufw default deny incoming
sudo ufw default allow outgoing

# Allow specific services
sudo ufw allow ssh
sudo ufw allow 'Nginx Full'
sudo ufw allow mysql

# Check status
sudo ufw status
```

### 2. SSL/TLS Configuration

#### Using Let's Encrypt (Certbot)

```bash
# Install Certbot
sudo apt install -y snapd
sudo snap install core; sudo snap refresh core
sudo snap install --classic certbot

# Create symlink
sudo ln -s /snap/bin/certbot /usr/bin/certbot

# Obtain certificate
sudo certbot --nginx -d your-domain.com -d www.your-domain.com

# Test automatic renewal
sudo certbot renew --dry-run
```

#### Using Custom SSL Certificate

If you have your own SSL certificate:

```bash
# Copy certificates
sudo mkdir -p /etc/ssl/private
sudo mkdir -p /etc/ssl/certs

# Copy your certificate files
sudo cp your-certificate.crt /etc/ssl/certs/
sudo cp your-private-key.key /etc/ssl/private/

# Set proper permissions
sudo chmod 644 /etc/ssl/certs/your-certificate.crt
sudo chmod 600 /etc/ssl/private/your-private-key.key
```

### 3. Additional Security Measures

#### Fail2Ban Configuration

```bash
# Install Fail2Ban
sudo apt install -y fail2ban

# Configure for SSH and Nginx
sudo tee /etc/fail2ban/jail.local << EOF
[DEFAULT]
bantime = 3600
findtime = 600
maxretry = 3

[ssh]
enabled = true
port = ssh
filter = sshd
logpath = /var/log/auth.log

[nginx-http-auth]
enabled = true
filter = nginx-http-auth
logpath = /var/log/nginx/error.log

[nginx-req-limit]
enabled = true
filter = nginx-req-limit
logpath = /var/log/nginx/error.log
EOF

sudo systemctl enable fail2ban
sudo systemctl start fail2ban
```

## Queue and Job Processing

### Configure Supervisor

```bash
# Install Supervisor
sudo apt install -y supervisor

# Create worker configuration
sudo tee /etc/supervisor/conf.d/hms-worker.conf << EOF
[program:hms-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/hms/artisan queue:work redis --sleep=3 --tries=3 --max-time=3600 --daemon
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/var/www/hms/storage/logs/worker.log
stopwaitsecs=3600
EOF

# Start workers
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start hms-worker:*
```

### Configure Cron Jobs

```bash
# Add Laravel scheduler
sudo -u www-data crontab -e

# Add this line:
* * * * * cd /var/www/hms && php artisan schedule:run >> /dev/null 2>&1
```

## Monitoring and Logging

### 1. Log Rotation

Create `/etc/logrotate.d/hms`:

```
/var/www/hms/storage/logs/*.log {
    daily
    missingok
    rotate 52
    compress
    delaycompress
    notifempty
    create 664 www-data www-data
    sharedscripts
    postrotate
        /bin/kill -USR1 `cat /var/run/nginx.pid 2>/dev/null` 2>/dev/null || true
    endscript
}
```

### 2. System Monitoring

#### Install Basic Monitoring Tools

```bash
# Install htop and iotop
sudo apt install -y htop iotop

# Install system monitoring
sudo apt install -y netdata
```

### 3. Application Monitoring

Consider implementing:
- **Application Performance Monitoring (APM)**
- **Error Tracking** (e.g., Sentry, Bugsnag)
- **Uptime Monitoring**
- **Log Aggregation** (e.g., ELK Stack)

## Backup and Recovery

### 1. Database Backups

Create backup script `/opt/backup-hms.sh`:

```bash
#!/bin/bash

# Configuration
DB_NAME="hospital_management_prod"
DB_USER="hms_prod"
DB_PASS="your_database_password"
BACKUP_DIR="/opt/backups/hms"
DATE=$(date +%Y%m%d_%H%M%S)

# Create backup directory
mkdir -p $BACKUP_DIR

# Database backup
mysqldump -u $DB_USER -p$DB_PASS $DB_NAME | gzip > $BACKUP_DIR/db_backup_$DATE.sql.gz

# File backup
tar -czf $BACKUP_DIR/files_backup_$DATE.tar.gz /var/www/hms/storage

# Remove backups older than 30 days
find $BACKUP_DIR -name "*.gz" -mtime +30 -delete

echo "Backup completed: $DATE"
```

Make executable and add to cron:

```bash
sudo chmod +x /opt/backup-hms.sh

# Add to root crontab for daily backup at 2 AM
sudo crontab -e
# Add line: 0 2 * * * /opt/backup-hms.sh >> /var/log/hms-backup.log 2>&1
```

### 2. File System Backups

Consider implementing:
- **Automated off-site backups**
- **Version control for configuration files**
- **Regular backup restoration testing**

## Performance Optimization

### 1. Enable OpCache

Already configured in PHP configuration above.

### 2. Configure Redis for Sessions and Cache

```bash
# Configure Redis (already installed)
sudo tee -a /etc/redis/redis.conf << EOF

# Memory optimization
maxmemory 1gb
maxmemory-policy allkeys-lru

# Persistence
save 900 1
save 300 10
save 60 10000
EOF

sudo systemctl restart redis
```

### 3. Database Optimization

```bash
# Run MySQL tuning script
sudo mysql -u root -p

# Analyze and optimize tables
ANALYZE TABLE users, doctors, patients, appointments, departments, payments, test_reports;
OPTIMIZE TABLE users, doctors, patients, appointments, departments, payments, test_reports;
```

## Post-Deployment Tasks

### 1. Final Security Checks

```bash
# Check file permissions
sudo find /var/www/hms -type f -exec chmod 644 {} \;
sudo find /var/www/hms -type d -exec chmod 755 {} \;
sudo chmod -R 775 /var/www/hms/storage
sudo chmod -R 775 /var/www/hms/bootstrap/cache

# Check .env file permissions
sudo chmod 600 /var/www/hms/.env
```

### 2. Test System Functionality

1. **Access the application** via HTTPS
2. **Login with admin credentials**
3. **Test core functionality**:
   - User management
   - Appointment scheduling
   - Patient management
   - Report generation

### 3. Monitor System Health

```bash
# Check all services
sudo systemctl status nginx
sudo systemctl status php8.2-fpm
sudo systemctl status mysql
sudo systemctl status redis
sudo supervisorctl status
```

### 4. Create Admin User (if needed)

```bash
# Create first admin user
sudo -u www-data php artisan tinker

# In tinker:
$user = \App\Models\User::create([
    'name' => 'System Administrator',
    'email' => 'admin@your-domain.com',
    'password' => bcrypt('secure_password_here')
]);
$user->assignRole('admin');
exit
```

## Maintenance and Updates

### Regular Maintenance Tasks

1. **Weekly**:
   - Review system logs
   - Check backup integrity
   - Monitor disk space
   - Review security logs

2. **Monthly**:
   - Update system packages
   - Update application dependencies
   - Review performance metrics
   - Test backup restoration

3. **Quarterly**:
   - Security audit
   - Performance optimization review
   - Capacity planning assessment

### Update Process

```bash
# 1. Backup system
/opt/backup-hms.sh

# 2. Update application
cd /var/www/hms
sudo -u www-data git pull origin main
sudo -u www-data composer install --no-dev --optimize-autoloader
sudo -u www-data npm ci --production
sudo -u www-data npm run build

# 3. Update database
sudo -u www-data php artisan migrate --force

# 4. Clear caches
sudo -u www-data php artisan config:cache
sudo -u www-data php artisan route:cache
sudo -u www-data php artisan view:cache

# 5. Restart services
sudo systemctl restart php8.2-fpm
sudo systemctl reload nginx
sudo supervisorctl restart hms-worker:*
```

## Troubleshooting

### Common Issues and Solutions

1. **500 Internal Server Error**
   - Check Nginx error logs: `/var/log/nginx/hms-error.log`
   - Check PHP-FPM logs: `/var/log/php8.2-fpm.log`
   - Verify file permissions

2. **Database Connection Issues**
   - Check MySQL status: `sudo systemctl status mysql`
   - Verify database credentials in `.env`
   - Check MySQL logs: `/var/log/mysql/error.log`

3. **Performance Issues**
   - Monitor system resources with `htop`
   - Check slow query log: `/var/log/mysql/slow.log`
   - Review Nginx access patterns

4. **Queue Jobs Not Processing**
   - Check Supervisor status: `sudo supervisorctl status`
   - Review worker logs: `/var/www/hms/storage/logs/worker.log`
   - Verify Redis connectivity

---

This production deployment guide ensures your Hospital Management System runs securely, efficiently, and reliably in a production environment. Always test deployment procedures in a staging environment first!

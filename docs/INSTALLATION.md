# Installation Guide

This guide will help you set up GGDy Gaming Store on your local machine or production server.

## System Requirements

### Minimum Requirements
- **PHP**: 7.4 or higher
- **MySQL**: 5.7 or higher
- **Web Server**: Apache 2.4+ or Nginx 1.18+
- **Memory**: 512MB RAM minimum
- **Storage**: 100MB free space

### Recommended Requirements
- **PHP**: 8.0 or higher
- **MySQL**: 8.0 or higher
- **Web Server**: Apache 2.4+ or Nginx 1.20+
- **Memory**: 1GB RAM or more
- **Storage**: 500MB free space

## Installation Methods

### Method 1: Using XAMPP (Recommended for Development)

1. **Download and Install XAMPP**
   - Download from [https://www.apachefriends.org/](https://www.apachefriends.org/)
   - Install with default settings
   - Start Apache and MySQL services

2. **Clone the Repository**
   ```bash
   git clone https://github.com/yourusername/GGDyWeb.git
   cd GGDyWeb
   ```

3. **Move to Web Directory**
   ```bash
   # Windows
   copy -r GGDyWeb C:\xampp\htdocs\
   
   # Linux/Mac
   cp -r GGDyWeb /opt/lampp/htdocs/
   ```

4. **Database Setup**
   - Open phpMyAdmin: `http://localhost/phpmyadmin`
   - Create new database: `ggdy_web`
   - Import `database.sql` file
   - Or run: `http://localhost/GGDyWeb/setup_database.php`

5. **Configuration**
   - Edit `config/database.php` if needed
   - Default settings should work with XAMPP

6. **Access the Application**
   - Open: `http://localhost/GGDyWeb/`
   - Login with: `webmaster` / `password`

### Method 2: Manual Installation

1. **Download Source Code**
   ```bash
   git clone https://github.com/yourusername/GGDyWeb.git
   cd GGDyWeb
   ```

2. **Web Server Setup**
   - Copy files to your web server's document root
   - Ensure PHP and MySQL are installed and running

3. **Database Configuration**
   ```bash
   # Create database
   mysql -u root -p
   CREATE DATABASE ggdy_web;
   exit
   
   # Import schema
   mysql -u root -p ggdy_web < database.sql
   ```

4. **Update Configuration**
   ```php
   // config/database.php
   define('DB_SERVER', 'localhost');
   define('DB_USERNAME', 'your_username');
   define('DB_PASSWORD', 'your_password');
   define('DB_NAME', 'ggdy_web');
   ```

5. **Set Permissions**
   ```bash
   # Linux/Mac
   chmod 755 -R GGDyWeb/
   chmod 644 GGDyWeb/*.php
   chmod 644 GGDyWeb/*.html
   chmod 644 GGDyWeb/*.css
   chmod 644 GGDyWeb/*.js
   ```

### Method 3: Docker Installation

1. **Create Dockerfile**
   ```dockerfile
   FROM php:8.0-apache
   
   # Install MySQL extension
   RUN docker-php-ext-install mysqli
   
   # Copy application files
   COPY . /var/www/html/
   
   # Set permissions
   RUN chown -R www-data:www-data /var/www/html
   ```

2. **Create docker-compose.yml**
   ```yaml
   version: '3.8'
   services:
     web:
       build: .
       ports:
         - "80:80"
       depends_on:
         - db
     
     db:
       image: mysql:8.0
       environment:
         MYSQL_ROOT_PASSWORD: rootpassword
         MYSQL_DATABASE: ggdy_web
       volumes:
         - ./database.sql:/docker-entrypoint-initdb.d/database.sql
   ```

3. **Run with Docker**
   ```bash
   docker-compose up -d
   ```

## Post-Installation Setup

### 1. Database Verification
- Check if all tables were created
- Verify sample data was inserted
- Test database connection

### 2. File Permissions
```bash
# Set proper permissions
find . -type d -exec chmod 755 {} \;
find . -type f -exec chmod 644 {} \;
```

### 3. Security Configuration
- Change default admin password
- Update database credentials
- Configure SSL/HTTPS (production)
- Set up firewall rules

### 4. Testing
- Test user registration
- Test product browsing
- Test shopping cart
- Test admin panel access

## Configuration Options

### Database Settings
```php
// config/database.php
define('DB_SERVER', 'localhost');     // Database server
define('DB_USERNAME', 'root');        // Database username
define('DB_PASSWORD', '');            // Database password
define('DB_NAME', 'ggdy_web');        // Database name
```

### Session Settings
```php
// config/session.php
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', 1); // Enable for HTTPS
```

### Application Settings
```php
// config/app.php (create if needed)
define('SITE_URL', 'http://localhost/GGDyWeb');
define('ADMIN_EMAIL', 'admin@ggdy.com');
define('MAX_UPLOAD_SIZE', 5242880); // 5MB
```

## Troubleshooting

### Common Issues

1. **Database Connection Failed**
   ```
   Error: Connection failed: Access denied for user
   ```
   - Check database credentials
   - Ensure MySQL service is running
   - Verify database exists

2. **Images Not Loading**
   ```
   Error: Failed to load resource
   ```
   - Check file paths
   - Verify image files exist
   - Check file permissions

3. **Session Issues**
   ```
   Error: Session not working
   ```
   - Check PHP session configuration
   - Verify session directory permissions
   - Clear browser cookies

4. **Permission Denied**
   ```
   Error: Permission denied
   ```
   - Check file permissions
   - Ensure web server has read access
   - Verify directory permissions

### Debug Mode
Enable debug mode by adding to PHP files:
```php
error_reporting(E_ALL);
ini_set('display_errors', 1);
```

### Log Files
Check these log files for errors:
- Apache error log: `/var/log/apache2/error.log`
- PHP error log: `/var/log/php_errors.log`
- MySQL error log: `/var/log/mysql/error.log`

## Production Deployment

### 1. Server Requirements
- Use a VPS or dedicated server
- Install LAMP/LEMP stack
- Configure SSL certificate
- Set up domain name

### 2. Security Hardening
- Change all default passwords
- Configure firewall
- Enable HTTPS
- Set up regular backups
- Configure monitoring

### 3. Performance Optimization
- Enable PHP OPcache
- Configure MySQL optimization
- Set up CDN for static files
- Enable Gzip compression

### 4. Backup Strategy
```bash
# Database backup
mysqldump -u username -p ggdy_web > backup_$(date +%Y%m%d).sql

# File backup
tar -czf files_backup_$(date +%Y%m%d).tar.gz /path/to/GGDyWeb/
```

## Support

If you encounter issues during installation:
1. Check the troubleshooting section
2. Search existing issues on GitHub
3. Create a new issue with detailed information

---

**Installation completed successfully!** 🎮

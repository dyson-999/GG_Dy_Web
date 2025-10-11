# GGDy Gaming Store - Deployment Guide

This guide shows you how to deploy your gaming store website to various hosting platforms.

## 🌐 Hosting Options

### Option 1: Free PHP/MySQL Hosting (Recommended)

#### 000WebHost (Most Popular)
1. **Sign Up**
   - Go to https://www.000webhost.com/
   - Click "Get Started Free"
   - Create account with email

2. **Create Website**
   - Choose "Create Website"
   - Enter website name: `ggdy-gaming-store`
   - Select PHP version (7.4 or higher)

3. **Upload Files**
   - Go to File Manager in control panel
   - Navigate to `public_html` folder
   - Upload all your project files
   - Make sure to upload the entire folder structure

4. **Database Setup**
   - Go to MySQL Databases in control panel
   - Create new database: `ggdy_web`
   - Create database user and assign to database
   - Import your `database.sql` file

5. **Update Configuration**
   - Edit `config/database.php` with new credentials:
   ```php
   define('DB_SERVER', 'localhost');
   define('DB_USERNAME', 'your_db_username');
   define('DB_PASSWORD', 'your_db_password');
   define('DB_NAME', 'ggdy_web');
   ```

6. **Access Your Website**
   - Your site will be available at: `https://yourusername.000webhostapp.com`

#### InfinityFree
1. **Sign Up**: https://infinityfree.net/
2. **Create Account**: Free registration
3. **Create Website**: Choose subdomain
4. **Upload Files**: Use File Manager
5. **Database**: Create MySQL database
6. **Import**: Upload database.sql

### Option 2: GitHub Pages (Static Only)

**Note**: GitHub Pages only supports static websites. Your PHP/MySQL features won't work.

#### Setup GitHub Pages
1. **Go to your GitHub repository**
2. **Click "Settings" tab**
3. **Scroll to "Pages" section**
4. **Source**: Deploy from a branch
5. **Branch**: Select `main`
6. **Folder**: `/ (root)`
7. **Click "Save"**

Your site will be available at: `https://yourusername.github.io/GGDyWeb`

**Limitations:**
- ❌ PHP scripts won't execute
- ❌ MySQL database won't work
- ❌ User registration/login won't work
- ❌ Admin panel won't work
- ✅ Static pages will display
- ✅ CSS/JavaScript will work

### Option 3: Paid Hosting (Full Features)

#### Shared Hosting Providers
- **Hostinger**: $1.99/month
- **Bluehost**: $2.95/month
- **SiteGround**: $3.99/month
- **A2 Hosting**: $2.99/month

#### VPS Hosting
- **DigitalOcean**: $5/month
- **Linode**: $5/month
- **Vultr**: $2.50/month

## 🚀 Quick Deployment Steps

### For Free Hosting (000WebHost)

1. **Prepare Files**
   ```
   - Ensure all files are in your project folder
   - Check that database.sql is included
   - Verify config/database.php exists
   ```

2. **Create Hosting Account**
   ```
   - Sign up at 000webhost.com
   - Verify email address
   - Create new website
   ```

3. **Upload Project**
   ```
   - Login to control panel
   - Open File Manager
   - Navigate to public_html
   - Upload all files (drag & drop or zip upload)
   ```

4. **Setup Database**
   ```
   - Go to MySQL Databases
   - Create database: ggdy_web
   - Create user and assign to database
   - Import database.sql file
   ```

5. **Update Configuration**
   ```
   - Edit config/database.php
   - Update database credentials
   - Save changes
   ```

6. **Test Website**
   ```
   - Visit your website URL
   - Test user registration
   - Test admin login (webmaster/password)
   - Check all features work
   ```

## 🔧 Configuration Updates

### Database Configuration
Update `config/database.php` with your hosting credentials:

```php
<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'your_hosting_db_username');
define('DB_PASSWORD', 'your_hosting_db_password');
define('DB_NAME', 'ggdy_web');

// Attempt to connect to MySQL database
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Create database if it doesn't exist
$sql = "CREATE DATABASE IF NOT EXISTS " . DB_NAME;
if (mysqli_query($conn, $sql)) {
    mysqli_select_db($conn, DB_NAME);
} else {
    die("Error creating database: " . mysqli_error($conn));
}
?>
```

### File Permissions
Ensure proper file permissions:
- Directories: 755
- Files: 644
- PHP files: 644

## 🐛 Troubleshooting

### Common Issues

1. **Database Connection Failed**
   - Check database credentials
   - Verify database exists
   - Ensure MySQL service is running

2. **Files Not Loading**
   - Check file paths
   - Verify all files uploaded
   - Check file permissions

3. **PHP Errors**
   - Enable error reporting
   - Check PHP version compatibility
   - Verify file syntax

4. **Images Not Displaying**
   - Check image file paths
   - Verify images uploaded correctly
   - Check file permissions

### Debug Mode
Add to top of PHP files for debugging:
```php
error_reporting(E_ALL);
ini_set('display_errors', 1);
```

## 📊 Performance Optimization

### For Production
1. **Enable Gzip compression**
2. **Optimize images**
3. **Minify CSS/JavaScript**
4. **Use CDN for static files**
5. **Enable caching**

### Security Checklist
- [ ] Change default admin password
- [ ] Update database credentials
- [ ] Enable HTTPS/SSL
- [ ] Set proper file permissions
- [ ] Regular backups
- [ ] Update PHP/MySQL versions

## 🌟 Recommended Hosting Providers

### Free Options
1. **000WebHost** - Best for beginners
2. **InfinityFree** - No ads, good performance
3. **Freehostia** - Reliable free hosting

### Paid Options
1. **Hostinger** - Great value, good support
2. **SiteGround** - Excellent performance
3. **DigitalOcean** - VPS with full control

## 📞 Support

If you encounter issues:
1. Check hosting provider documentation
2. Contact hosting support
3. Check error logs
4. Test locally first

---

**Your gaming store will be live and accessible worldwide!** 🎮

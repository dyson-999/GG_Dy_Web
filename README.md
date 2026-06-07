# GGDy - Dy Gaming Store

A modern, responsive e-commerce website for gaming products built with HTML, CSS, JavaScript, PHP, and MySQL.

![GGDy Gaming Store](https://img.shields.io/badge/Status-Live-brightgreen)
![PHP](https://img.shields.io/badge/PHP-7.4+-blue)
![MySQL](https://img.shields.io/badge/MySQL-5.7+-orange)
![JavaScript](https://img.shields.io/badge/JavaScript-ES6+-yellow)

## Features

### Frontend Features
- **Modern Gaming UI**: Dark theme with red accents and gaming aesthetics
- **Responsive Design**: Mobile-first approach with smooth animations
- **Interactive Shopping Cart**: Real-time cart updates with localStorage
- **Product Catalog**: Dynamic product grid with filtering and search
- **Flash Deals**: Countdown timers for limited-time offers
- **User Reviews**: Community-driven product reviews
- **Discussion Forum**: User-generated content and discussions
- **AI Recommendations**: Personalized product suggestions
- **Image Slideshow**: Auto-rotating product banners

### Backend Features
- **User Authentication**: Secure login/registration system
- **Admin Panel**: Comprehensive webmaster dashboard
- **Product Management**: CRUD operations for products
- **User Management**: Role-based access control
- **Order Management**: Complete order processing system
- **FAQ System**: Dynamic FAQ management
- **Database Integration**: MySQL with prepared statements

### Security Features
- **Password Hashing**: Secure password storage with PHP's password_hash()
- **SQL Injection Prevention**: Prepared statements throughout
- **Session Management**: Secure session handling
- **Input Validation**: Server-side validation for all inputs

## Quick Start

### Prerequisites
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Web server (Apache/Nginx)
- Modern web browser

### Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/yourusername/GGDyWeb.git
   cd GGDyWeb
   ```

2. **Database Setup**
   - Create a MySQL database named `ggdy_web`
   - Import the database schema:
     ```bash
     mysql -u root -p ggdy_web < database.sql
     ```
   - Or run the setup script: `http://localhost/GGDyWeb/setup_database.php`

3. **Configuration**
   - Update database credentials in `config/database.php`:
     ```php
     define('DB_SERVER', 'localhost');
     define('DB_USERNAME', 'your_username');
     define('DB_PASSWORD', 'your_password');
     define('DB_NAME', 'ggdy_web');
     ```

4. **Web Server Setup**
   - Place the project in your web server's document root
   - Ensure PHP and MySQL extensions are enabled
   - Set proper file permissions (755 for directories, 644 for files)

5. **Access the Application**
   - Open your browser and navigate to your web server URL
   - Default webmaster login: `webmaster` / `password`

## Project Structure

```
GGDyWeb/
├── admin/                 # Admin panel files
│   ├── index.php         # Webmaster dashboard
│   ├── users.php         # User management
│   ├── products.php      # Product management
│   └── faqs.php          # FAQ management
├── auth/                 # Authentication files
│   ├── login.php         # Login handler
│   ├── register.php      # Registration handler
│   └── logout.php        # Logout handler
├── config/               # Configuration files
│   ├── database.php      # Database connection
│   ├── session.php       # Session management
│   ├── products.php      # Product functions
│   └── cart.php          # Cart functions
├── images/               # Product and UI images
├── *.html                # Frontend pages
├── *.php                 # PHP scripts
├── *.css                 # Stylesheets
├── *.js                  # JavaScript files
├── database.sql          # Database schema
└── README.md             # This file
```

## Key Pages

- **Homepage** (`GGDy.html`): Main landing page with featured products
- **Shop** (`shop.html`): Product catalog with filtering
- **Product Pages**: Individual product details
- **Login/Register**: User authentication
- **Admin Panel** (`admin/`): Webmaster dashboard
- **Cart**: Shopping cart functionality

## Technologies Used

### Frontend
- **HTML5**: Semantic markup
- **CSS3**: Modern styling with animations
- **JavaScript (ES6+)**: Interactive functionality
- **Font Awesome**: Icons and UI elements

### Backend
- **PHP 7.4+**: Server-side scripting
- **MySQL**: Database management
- **Sessions**: User state management

### Tools & Libraries
- **LocalStorage**: Client-side data persistence
- **Responsive Design**: Mobile-first approach
- **CSS Grid & Flexbox**: Modern layout techniques

## 🔧 Configuration

### Database Configuration
Edit `config/database.php` to match your database settings:

```php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'your_username');
define('DB_PASSWORD', 'your_password');
define('DB_NAME', 'ggdy_web');
```

### Default Admin Account
- **Username**: `webmaster`
- **Password**: `password`
- **Role**: `webmaster`

> **Important**: Change the default password after first login!

## Customization

### Styling
- Main stylesheet: `style.css`
- Color scheme: Dark theme with red (#ff0000) accents
- Typography: Arial, sans-serif
- Responsive breakpoints: 768px, 1024px

### Adding Products
1. Access the admin panel
2. Navigate to Product Management
3. Use the "Add New Product" feature
4. Upload product images to the `images/` directory

### Modifying Features
- Cart functionality: `script.js` (lines 5-166)
- Product filtering: `sidebar.js`
- Authentication: `auth/` directory
- Database operations: `config/` directory

## Troubleshooting

### Common Issues

1. **Database Connection Failed**
   - Check database credentials in `config/database.php`
   - Ensure MySQL service is running
   - Verify database exists

2. **Images Not Loading**
   - Check file paths in HTML/CSS
   - Verify image files exist in `images/` directory
   - Check file permissions

3. **Session Issues**
   - Ensure PHP sessions are enabled
   - Check session configuration in `config/session.php`
   - Clear browser cookies

4. **Cart Not Working**
   - Check JavaScript console for errors
   - Verify localStorage is enabled
   - Ensure `script.js` is properly linked

### Debug Mode
Enable error reporting by adding to the top of PHP files:
```php
error_reporting(E_ALL);
ini_set('display_errors', 1);
```

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## Documentation

- **[Installation Guide](docs/INSTALLATION.md)** - Detailed setup instructions
- **[API Documentation](docs/API.md)** - Complete API reference
- **[Deployment Guide](docs/DEPLOYMENT-GUIDE.md)** - How to deploy to various hosting platforms
- **[Project Structure](PROJECT-STRUCTURE.md)** - Understanding the codebase organization
- **[Contributing Guidelines](CONTRIBUTING.md)** - How to contribute to the project
- **[Security Policy](SECURITY.md)** - Security guidelines and vulnerability reporting


## Future Enhancements

- [ ] Payment gateway integration
- [ ] Advanced search functionality
- [ ] Email notifications
- [ ] Product reviews with ratings
- [ ] Wishlist functionality
- [ ] Multi-language support
- [ ] API endpoints
- [ ] Mobile app integration

---

**Made for the gaming community**

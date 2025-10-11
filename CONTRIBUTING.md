# Contributing to GGDy Gaming Store

Thank you for your interest in contributing to GGDy! This document provides guidelines and information for contributors.

## 🚀 Getting Started

### Prerequisites
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Git
- A modern web browser
- Basic knowledge of HTML, CSS, JavaScript, and PHP

### Setting Up Development Environment

1. **Fork and Clone**
   ```bash
   git clone https://github.com/yourusername/GGDyWeb.git
   cd GGDyWeb
   ```

2. **Database Setup**
   - Create a local MySQL database
   - Import the schema from `database.sql`
   - Update `config/database.php` with your credentials

3. **Local Server**
   - Use XAMPP, WAMP, or similar for local development
   - Ensure PHP and MySQL services are running

## 📋 How to Contribute

### Reporting Bugs

1. Check existing issues to avoid duplicates
2. Use the bug report template
3. Include:
   - Clear description of the issue
   - Steps to reproduce
   - Expected vs actual behavior
   - Screenshots if applicable
   - Browser/OS information

### Suggesting Features

1. Check existing feature requests
2. Use the feature request template
3. Include:
   - Clear description of the feature
   - Use case and benefits
   - Mockups or examples if applicable

### Code Contributions

1. **Create a Branch**
   ```bash
   git checkout -b feature/your-feature-name
   ```

2. **Make Changes**
   - Follow the coding standards below
   - Write clear, commented code
   - Test your changes thoroughly

3. **Commit Changes**
   ```bash
   git commit -m "Add: Brief description of changes"
   ```

4. **Push and Create PR**
   ```bash
   git push origin feature/your-feature-name
   ```

## 📝 Coding Standards

### PHP
- Use PSR-12 coding standards
- Use meaningful variable and function names
- Add comments for complex logic
- Use prepared statements for database queries
- Validate all user inputs

### JavaScript
- Use ES6+ features
- Use meaningful variable names
- Add JSDoc comments for functions
- Handle errors gracefully
- Use const/let instead of var

### CSS
- Use consistent indentation (2 spaces)
- Use meaningful class names
- Follow BEM methodology when possible
- Use CSS Grid and Flexbox for layouts
- Keep styles organized and commented

### HTML
- Use semantic HTML5 elements
- Include proper alt attributes for images
- Ensure accessibility standards
- Use consistent indentation

## 🧪 Testing

### Before Submitting
- [ ] Test on multiple browsers (Chrome, Firefox, Safari, Edge)
- [ ] Test responsive design on different screen sizes
- [ ] Verify all forms work correctly
- [ ] Check for JavaScript errors in console
- [ ] Test database operations
- [ ] Verify security measures (SQL injection, XSS)

### Test Cases to Consider
- User registration and login
- Product browsing and filtering
- Shopping cart functionality
- Admin panel operations
- Form validations
- Error handling

## 📁 Project Structure Guidelines

### File Organization
- Keep related files together
- Use descriptive file names
- Follow the existing directory structure
- Place new images in appropriate subdirectories

### Database Changes
- Always provide migration scripts
- Update the main `database.sql` file
- Document schema changes
- Test on clean database

## 🔒 Security Guidelines

### Data Handling
- Never commit sensitive data (passwords, API keys)
- Use prepared statements for all database queries
- Validate and sanitize all user inputs
- Implement proper session management

### Authentication
- Use secure password hashing
- Implement proper logout functionality
- Check user permissions for admin functions
- Use HTTPS in production

## 📖 Documentation

### Code Documentation
- Add comments for complex functions
- Update README.md for new features
- Document API endpoints if applicable
- Include setup instructions for new dependencies

### Commit Messages
Use clear, descriptive commit messages:
- `Add: New feature description`
- `Fix: Bug description`
- `Update: Change description`
- `Remove: Removed feature description`
- `Docs: Documentation update`

## 🎯 Areas for Contribution

### High Priority
- Security improvements
- Performance optimizations
- Mobile responsiveness
- Accessibility improvements
- Code refactoring

### Feature Ideas
- Payment gateway integration
- Advanced search functionality
- Email notifications
- Product reviews with ratings
- Wishlist functionality
- Multi-language support
- API development

### Bug Fixes
- Cross-browser compatibility issues
- Mobile layout problems
- Performance bottlenecks
- Security vulnerabilities

## 🤝 Community Guidelines

### Be Respectful
- Use welcoming and inclusive language
- Be respectful of differing viewpoints
- Accept constructive criticism gracefully
- Focus on what's best for the community

### Communication
- Use clear, concise language
- Provide context for suggestions
- Ask questions when unsure
- Help others when possible

## 📞 Getting Help

### Resources
- Check existing documentation
- Search through existing issues
- Ask questions in discussions
- Contact maintainers if needed

### Contact
- Create an issue for bugs or features
- Use discussions for questions
- Email: dilshanudara512@gmail.com

## 🏆 Recognition

Contributors will be recognized in:
- README.md contributors section
- Release notes
- Project documentation

Thank you for contributing to GGDy Gaming Store! 🎮

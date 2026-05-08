# 🎓 Apex Internship Portfolio Website

A professional, full-stack portfolio website built with **HTML5, CSS3, JavaScript, PHP, and MySQL**. This project demonstrates all core technologies from the Apex Web Development internship curriculum (Days 1-12).

## 📋 Project Overview

**Technologies Used:**
- **Frontend**: HTML5 (semantic), CSS3 (flexbox, grid, animations), JavaScript (vanilla, DOM manipulation)
- **Backend**: PHP 7.x+ (forms, validation, server-side processing)
- **Database**: MySQL (tables, relationships, CRUD operations)
- **Environment**: XAMPP/WAMP (Apache, PHP, MySQL)
- **Version Control**: Git & GitHub

**Features:**
✅ Responsive Design (Mobile, Tablet, Desktop)  
✅ Contact Form with Validation & Database Storage  
✅ Dynamic Project Gallery  
✅ Skills Showcase  
✅ Smooth Animations & Transitions  
✅ Mobile Menu Toggle  
✅ SEO-Optimized HTML5  
✅ CSS3 Flexbox & Grid Layouts  
✅ JavaScript Form Validation  
✅ PHP Backend Processing  
✅ MySQL Database Integration  

---

## 🚀 Quick Start

### 1. **Setup XAMPP Environment**

#### Windows:
```bash
# Download XAMPP from https://www.apachefriends.org/
# Install with default settings
# Start Apache and MySQL servers from Control Panel
```

### 2. **Clone/Setup Project**

```bash
# Navigate to htdocs folder
cd "C:\xampp\htdocs"

# Clone the repository (or copy project files)
git clone https://github.com/username/portfolio.git
cd portfolio
```

### 3. **Create Database**

```bash
# Method 1: Using phpMyAdmin
# 1. Open browser and go to: http://localhost/phpmyadmin
# 2. Click "New" → Create new database: "portfolio_db"
# 3. Select database → Import "database/portfolio_db.sql"

# Method 2: Using Command Line
mysql -u root -p < database/portfolio_db.sql
```

### 4. **Run Locally**

```bash
# Open browser and navigate to:
http://localhost/portfolio/

# Or if in htdocs root:
http://localhost/
```

---

## 📁 Project Structure

```
portfolio/
├── index.html                 # Main page (HTML5: semantic, forms, multimedia)
├── css/
│   └── style.css             # CSS3: flexbox, grid, animations, media queries
├── js/
│   └── script.js             # JavaScript: DOM manipulation, events, validation
├── php/
│   ├── config.php            # Database configuration & helper functions
│   ├── contact.php           # Contact form backend (POST, validation, INSERT)
│   └── get_projects.php      # Retrieve projects from database
├── database/
│   └── portfolio_db.sql      # MySQL database schema & sample data
├── .github/
│   └── agents/
│       └── full-stack-builder.agent.md  # VS Code agent (optional)
├── .gitignore                # Git ignore patterns
└── README.md                 # This file
```

---

## 🛠️ Technologies Breakdown

### **HTML5** (Days 5-7 Curriculum)
- Semantic tags: `<header>`, `<nav>`, `<section>`, `<article>`, `<footer>`
- Form elements: `<input>`, `<textarea>`, `<label>`
- Attributes: `data-*`, `aria-*`, responsive `<meta>` viewport
- Best practices: Proper document structure, accessibility

**Files**: `index.html`

### **CSS3** (Days 5-7 Curriculum)
- **Flexbox**: Navigation bar, footer layouts
- **Grid**: Projects grid, skills grid, responsive cards
- **Animations**: `@keyframes`, transitions on hover, loading animations
- **Media Queries**: Responsive design (480px, 768px breakpoints)
- **Colors & Styling**: Gradients, shadows, borders, pseudo-elements

**Files**: `css/style.css` (600+ lines)

### **JavaScript** (Days 5-7 Curriculum)
- **DOM Manipulation**: `querySelector`, `addEventListener`, class toggling
- **Form Validation**: Real-time validation, error messaging, regex patterns
- **Events**: Click, blur, input, submit handlers
- **Fetch API**: Send contact form data to PHP backend
- **Intersection Observer**: Scroll animations
- **Local Storage**: (Optional) Save form preferences

**Files**: `js/script.js`

### **PHP** (Days 8-12 Curriculum)
- **Form Handling**: `$_POST`, `$_GET`, `$_REQUEST`
- **Validation**: `filter_var()`, `strlen()`, regex patterns
- **Sanitization**: `htmlspecialchars()`, `mysqli_real_escape_string()`
- **Database Connection**: `mysqli_connect()`, prepared statements
- **Error Handling**: Try-catch, error logging, user-friendly messages
- **JSON Response**: Return data as JSON for AJAX calls

**Files**: `php/config.php`, `php/contact.php`, `php/get_projects.php`

### **MySQL** (Days 8-12 Curriculum)
- **Database Design**: 3 tables (contact_messages, projects, skills)
- **Data Types**: INT, VARCHAR, LONGTEXT, BOOLEAN, TIMESTAMP
- **Keys**: PRIMARY KEY, AUTO_INCREMENT
- **Relationships**: Foreign keys (optional expansion)
- **CRUD Operations**: CREATE, INSERT, SELECT, UPDATE, DELETE
- **Indexes**: Performance optimization
- **Queries**: SELECT with WHERE, ORDER BY, GROUP_CONCAT, JOINs

**Files**: `database/portfolio_db.sql`

---

## 📚 Learning Objectives Covered

### **Foundation & Environment Setup** (Days 1-4)
- ✅ XAMPP installation and configuration
- ✅ Apache & MySQL server startup
- ✅ phpMyAdmin database management
- ✅ Git initialization and version control

### **HTML5 Fundamentals** (Days 5)
- ✅ Semantic HTML5 structure
- ✅ Forms (input, textarea, validation)
- ✅ Metadata and SEO optimization

### **CSS3 Styling** (Days 6)
- ✅ Flexbox layouts
- ✅ CSS Grid
- ✅ Animations & transitions
- ✅ Responsive design (media queries)
- ✅ Color, gradients, shadows

### **JavaScript Basics** (Days 7)
- ✅ Variables and data types
- ✅ Loops and conditionals
- ✅ Functions
- ✅ DOM manipulation
- ✅ Event handling
- ✅ Form validation
- ✅ Fetch API for async requests

### **PHP Basics** (Days 8-10)
- ✅ PHP syntax and variables
- ✅ Arrays and loops
- ✅ Functions
- ✅ Form handling ($_POST, $_GET)
- ✅ Form validation
- ✅ Error handling

### **MySQL Basics** (Days 11-12)
- ✅ Database creation
- ✅ Table design
- ✅ INSERT, SELECT, UPDATE operations
- ✅ Primary keys and relationships
- ✅ phpMyAdmin usage
- ✅ SQL queries

---

## 🔧 Configuration

### **Database Connection** (config.php)

Default settings (XAMPP defaults):
```php
DB_HOST = 'localhost'   // Local development
DB_USER = 'root'        // XAMPP default user
DB_PASS = ''            // XAMPP default (empty)
DB_NAME = 'portfolio_db' // Database name
```

### **Contact Form** (contact.php)

1. Create database and import SQL file
2. Update email recipient (optional):
   ```php
   $to = 'your-email@example.com';
   ```
3. Test form at `http://localhost/portfolio#contact`

---

## 📝 Git Workflow

This project includes **10+ meaningful commits** demonstrating:

1. Initial project setup
2. HTML structure and semantic markup
3. CSS styling and responsive design
4. JavaScript interactivity
5. PHP contact form backend
6. MySQL database integration
7. Form validation
8. Error handling
9. Documentation
10. Final polish and optimization

### **Commit Examples**

```bash
git init
git add .
git commit -m "Initial project setup with HTML structure"
git commit -m "Add CSS3 styling with flexbox and grid layouts"
git commit -m "Implement JavaScript form validation"
git commit -m "Create PHP contact form handler"
git commit -m "Setup MySQL database schema"
git commit -m "Add mobile responsive design"
git commit -m "Implement database integration"
git commit -m "Add animations and transitions"
```

---

## 🧪 Testing Checklist

### **Frontend Testing**
- [ ] Open `http://localhost/portfolio/` in browser
- [ ] Test responsive design (resize window, use mobile device)
- [ ] Click navigation links (smooth scroll to sections)
- [ ] Test hamburger menu on mobile
- [ ] Verify all images and content load correctly

### **Form Validation Testing**
- [ ] Submit empty form (should show errors)
- [ ] Enter invalid email (should show error)
- [ ] Type in short messages (should validate minimum length)
- [ ] Test real-time validation (errors clear as you type)
- [ ] Submit valid form (should show success message)

### **Database Testing** (phpMyAdmin)
1. Go to `http://localhost/phpmyadmin`
2. Select `portfolio_db` database
3. View `contact_messages` table
4. Submit contact form on website
5. Verify message appears in database

### **PHP Testing**
- [ ] Check `php/contact.php` processes POST request
- [ ] Verify sanitization of inputs
- [ ] Test error handling (invalid database)
- [ ] Check response JSON format

---

## 🐛 Troubleshooting

### **"Connection Refused" Error**
- Ensure XAMPP Apache & MySQL are running
- Check Services → Start MySQL and Apache

### **"Database doesn't exist" Error**
- Import `database/portfolio_db.sql` using phpMyAdmin
- Or run: `mysql -u root -p < database/portfolio_db.sql`

### **Form Not Submitting**
- Check browser console (F12) for JavaScript errors
- Verify `php/contact.php` path is correct
- Ensure form field names match JS code

### **CSS/JS Not Loading**
- Check file paths (relative vs absolute)
- Clear browser cache (Ctrl+Shift+Delete)
- Check browser console for 404 errors

### **XAMPP Port Conflicts**
- If port 80 busy: Change Apache port in `httpd.conf`
- If port 3306 busy: Change MySQL port in `my.ini`

---

## 📚 Curriculum Reference

| Topic | Days | Files | Status |
|-------|------|-------|--------|
| Environment Setup | 1-4 | .gitignore, README | ✅ Complete |
| HTML5 Fundamentals | 5 | index.html | ✅ Complete |
| CSS3 Styling | 6 | css/style.css | ✅ Complete |
| JavaScript Basics | 7 | js/script.js | ✅ Complete |
| PHP Basics | 8-10 | php/*.php | ✅ Complete |
| MySQL Basics | 11-12 | database/portfolio_db.sql | ✅ Complete |
| **Total** | **1-12** | **All Files** | **✅ COMPLETE** |

---

## 🎯 Next Steps (Optional Enhancements)

1. **Add Blog Section** - Create blog tables in MySQL
2. **Implement Authentication** - Login/signup with sessions
3. **Add Image Upload** - Store portfolio images in database
4. **Email Notifications** - Send confirmation emails
5. **Admin Dashboard** - Manage projects and messages
6. **Deployment** - Host on Bluehost/GoDaddy
7. **SSL Certificate** - Make website HTTPS
8. **API** - Create REST API for CRUD operations

---

## 📖 Resources

- [HTML5 Documentation](https://developer.mozilla.org/en-US/docs/Web/HTML)
- [CSS3 Guide](https://developer.mozilla.org/en-US/docs/Web/CSS)
- [JavaScript Reference](https://developer.mozilla.org/en-US/docs/Web/JavaScript)
- [PHP Manual](https://www.php.net/manual/)
- [MySQL Documentation](https://dev.mysql.com/doc/)
- [XAMPP Docs](https://www.apachefriends.org/docs.html)

---

## 👩‍💼 Author

**Sravya Rangu**  
Apex Internship - Web Development Program  
2026

---

## 📄 License

This project is open source and available under the MIT License.

---

## ✨ Key Takeaways

This portfolio website demonstrates:
- **Full-stack development** across frontend, backend, and database layers
- **Best practices** in HTML5 semantics, CSS3 layouts, and JavaScript patterns
- **Security** with input validation and sanitization
- **Responsive design** working on all device sizes
- **Git workflow** with meaningful commits
- **Database fundamentals** with MySQL schema design
- **Server-side processing** with PHP form handling

**Perfect for** portfolio showcase, job interviews, and internship completion! 🚀

---

*Last updated: May 2026*  
*Portfolio Version: 1.0*

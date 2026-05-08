# Database Setup Guide

## Prerequisites
- XAMPP installed and running
- Apache server started
- MySQL server started
- phpMyAdmin accessible at http://localhost/phpmyadmin

## Method 1: Import SQL File (Recommended)

### Step 1: Open phpMyAdmin
1. Navigate to: http://localhost/phpmyadmin
2. Login with username: `root` (no password for XAMPP default)

### Step 2: Create Database
1. Click "New" on the left sidebar
2. Enter database name: `portfolio_db`
3. Charset: `utf8mb4` (recommended for international characters)
4. Click "Create"

### Step 3: Import SQL File
1. Go to: http://localhost/phpmyadmin/?db=portfolio_db
2. Click "Import" tab at top
3. Click "Choose File" button
4. Select: `database/portfolio_db.sql`
5. Execution: Make sure "SQL" is selected
6. Click "Import" button at bottom

### Step 4: Verify Import
1. Go to "portfolio_db" database
2. Should see 3 tables:
   - `contact_messages`
   - `projects`
   - `skills`
3. Check each table has sample data

---

## Method 2: Command Line Import

### Step 1: Open Command Prompt/Terminal
```bash
# Windows Command Prompt
cd C:\xampp\mysql\bin

# Or add to PATH for direct access
```

### Step 2: Run MySQL Import
```bash
mysql -u root -p < "C:\path\to\portfolio_db.sql"
```

When prompted for password, press Enter (default XAMPP has no password)

### Step 3: Verify with MySQL Client
```bash
mysql -u root -p < run this command

# Then type:
USE portfolio_db;
SHOW TABLES;
SELECT COUNT(*) FROM contact_messages;
```

---

## Method 3: Manual Table Creation

If import fails, create tables manually:

### Table 1: contact_messages
```sql
CREATE TABLE contact_messages (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    subject VARCHAR(200) NOT NULL,
    message LONGTEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    is_read BOOLEAN DEFAULT FALSE,
    replied BOOLEAN DEFAULT FALSE,
    reply_message LONGTEXT NULL,
    replied_at TIMESTAMP NULL
);

CREATE INDEX idx_email ON contact_messages(email);
CREATE INDEX idx_created_at ON contact_messages(created_at);
```

### Table 2: projects
```sql
CREATE TABLE projects (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(150) NOT NULL,
    description LONGTEXT NOT NULL,
    technologies VARCHAR(255) NOT NULL,
    project_url VARCHAR(255),
    github_url VARCHAR(255),
    image_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    is_active BOOLEAN DEFAULT TRUE
);
```

### Table 3: skills
```sql
CREATE TABLE skills (
    id INT PRIMARY KEY AUTO_INCREMENT,
    category VARCHAR(100) NOT NULL,
    skill_name VARCHAR(150) NOT NULL,
    proficiency_level ENUM('Beginner', 'Intermediate', 'Advanced', 'Expert') DEFAULT 'Intermediate',
    display_order INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

---

## Verification Checklist

- [ ] Database `portfolio_db` exists
- [ ] Table `contact_messages` has sample data
- [ ] Table `projects` has 3 sample projects
- [ ] Table `skills` has 20 sample skills
- [ ] Indexes created on contact_messages
- [ ] All columns have correct data types
- [ ] Default values set correctly

---

## Backup Database

### Export (Backup)
```bash
mysql -u root -p portfolio_db > backup_$(date +%Y%m%d_%H%M%S).sql
```

### Restore from Backup
```bash
mysql -u root -p portfolio_db < backup_20260508_100000.sql
```

---

## Troubleshooting

### Error: "Access denied for user 'root'@'localhost'"
- XAMPP MySQL may have a default password
- Try: `mysql -u root -p` then enter password or press Enter

### Error: "Unknown database 'portfolio_db'"
- Database doesn't exist
- Create it first: `CREATE DATABASE portfolio_db;`
- Then import SQL file

### Syntax Error During Import
- File encoding might be wrong
- Ensure SQL file is UTF-8 encoded
- Try importing via phpMyAdmin instead

### phpMyAdmin Not Loading
- Ensure Apache is running
- Check: http://localhost/phpmyadmin/
- If not available, start XAMPP Control Panel

### MySQL Port Already in Use
- Check Services or Task Manager for MySQL process
- Change MySQL port in C:\xampp\mysql\bin\my.ini
- Restart MySQL service

---

## Database Credentials (XAMPP Defaults)

```php
// php/config.php should use:
$dbhost = 'localhost'; // Host
$dbuser = 'root';      // Username
$dbpass = '';          // Password (empty for XAMPP)
$dbname = 'portfolio_db'; // Database name
```

---

## Next Steps

1. ✅ Database created and populated
2. Run website: `http://localhost/portfolio/`
3. Test contact form
4. Verify messages saved in database
5. View messages in phpMyAdmin

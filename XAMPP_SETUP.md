# XAMPP Setup & Configuration Guide

## Installation

### Windows
1. Download XAMPP from: https://www.apachefriends.org/
2. Run installer (xampp-windows-x64-installer.exe)
3. Select components:
   - Apache (required)
   - MySQL (required)
   - PHP (required)
   - phpMyAdmin (recommended)
4. Choose installation path: `C:\xampp` (default)
5. Complete installation

### macOS
1. Download XAMPP for OS X
2. Mount DMG file
3. Run XAMPP installer
4. Follow prompts to install

### Linux
```bash
# Ubuntu/Debian
wget https://www.apachefriends.org/xampp-linux-installer
chmod +x xamppinstaller
sudo ./xamppinstaller
```

---

## Starting Services

### Windows
1. Open "XAMPP Control Panel" from Start Menu
2. Click "Start" next to Apache
3. Click "Start" next to MySQL
4. Wait for both to show "Running" status

### macOS/Linux
```bash
# Start all services
sudo /Applications/XAMPP/xamppfiles/mampp start

# Or manually start Apache
sudo /Applications/XAMPP/xamppfiles/bin/apachectl start

# Start MySQL
sudo /Applications/XAMPP/xamppfiles/bin/mysql.server start
```

---

## Verify Installation

### Test Apache
1. Open browser
2. Navigate to: http://localhost/
3. Should see XAMPP Dashboard

### Test PHP
1. Go to: http://localhost/dashboard/
2. Should display PHP version and info

### Test MySQL (phpMyAdmin)
1. Navigate to: http://localhost/phpmyadmin
2. Should see phpMyAdmin interface
3. Login with username: `root` (no password)

---

## Project Setup

### Windows
```bash
# Copy project to htdocs
cd C:\xampp\htdocs
# Place portfolio folder here
# Access at: http://localhost/portfolio/
```

### macOS/Linux
```bash
# Copy project to htdocs
sudo cp -r portfolio /Applications/XAMPP/xamppfiles/htdocs/
# Access at: http://localhost/portfolio/
```

---

## Configuration Files

### Apache Configuration
- **Location**: `C:\xampp\apache\conf\httpd.conf`
- **Port**: 80 (default)
- **Virtual Hosts**: Configure in `httpd-vhosts.conf`

### PHP Configuration
- **Location**: `C:\xampp\php\php.ini`
- **Memory Limit**: 128M (default)
- **Upload Size**: 40M (default)

### MySQL Configuration
- **Location**: `C:\xampp\mysql\bin\my.ini`
- **Port**: 3306 (default)
- **Data Directory**: `C:\xampp\mysql\data`

---

## Common Port Issues

### Port 80 Already in Use
1. Open Services (services.msc)
2. Find what's using port 80
3. Stop that service or change Apache port

### Change Apache Port
1. Edit `C:\xampp\apache\conf\httpd.conf`
2. Find: `Listen 80`
3. Change to: `Listen 8080`
4. Restart Apache

### Port 3306 In Use (MySQL)
1. Edit `C:\xampp\mysql\bin\my.ini`
2. Find: `port=3306`
3. Change to: `port=3307`
4. Restart MySQL

---

## Enable PHP Extensions

### For Contact Form/Database

Edit `php.ini`:
```ini
; Uncomment for MySQL extension
extension=mysqli

; For file uploads
extension=fileinfo
upload_max_filesize = 40M
post_max_size = 40M
```

---

## Using VS Code with XAMPP

### VS Code Extensions
- PHP Intelephense (Intellisense for PHP)
- PHP Server (Run PHP locally)
- MySQL (Database management)

### Launch Configuration
```json
{
    "version": "0.2.0",
    "configurations": [
        {
            "name": "Listen for XDebug",
            "type": "php",
            "port": 9003,
            "pathMapping": {
                "/": "${workspaceFolder}/",
                "/portfolio": "${workspaceFolder}"
            }
        }
    ]
}
```

---

## Security Best Practices

### Change MySQL Password (XAMPP Default)
```bash
mysql -u root
ALTER USER 'root'@'localhost' IDENTIFIED BY 'new_password';
FLUSH PRIVILEGES;
EXIT;
```

### Restrict phpMyAdmin Access
1. Edit `C:\xampp\apache\conf\extra\httpd-xampp.conf`
2. Add password protection to phpMyAdmin section

### Disable Unnecessary Services
1. XAMPP Control Panel → Config
2. Service Port: Uncheck services you don't need

---

## Updating XAMPP

1. Backup your project and databases
2. Export databases from phpMyAdmin
3. Download newer XAMPP version
4. Install fresh XAMPP in new directory
5. Restore databases and projects
6. Update configuration files if needed

---

## Troubleshooting

### Apache Won't Start
```
Error: Port 80 is busy or Apache error
- Check: Services (services.msc)
- Check: Resource Monitor for port 80
- Try: Change to port 8080
```

### MySQL Won't Start
```
Error: MySQL service error
- Check: MySQL data directory permissions
- Check: MySQL port 3306 available
- Try: Delete ibdata1 file in mysql/data (only if no important data)
```

### PHP Not Working
```
Error: White screen or blank page
- Check: php.ini settings
- Check: Browser console for errors
- Check: Apache error log
- Try: Test with simple <?php phpinfo(); ?>
```

### Can't Connect to Database
```
Error: "Connection refused" or "Unknown host"
- Verify: MySQL is running
- Check: Database name is correct
- Check: Username and password
- Verify: port 3306 is accessible
```

---

## Useful XAMPP Commands

### Windows Command Prompt
```bash
# Start Apache
net start Apache2.4

# Stop Apache
net stop Apache2.4

# Start MySQL
net start MySQL80

# Stop MySQL
net stop MySQL80
```

### Check XAMPP Logs
```bash
# Apache Error Log
C:\xampp\apache\logs\error.log

# Apache Access Log
C:\xampp\apache\logs\access.log

# MySQL Error Log
C:\xampp\mysql\data\<hostname>.err
```

---

## Next Steps

1. ✅ XAMPP installed
2. ✅ Apache & MySQL running
3. ✅ phpMyAdmin accessible
4. Deploy portfolio project
5. Import database schema
6. Test contact form functionality

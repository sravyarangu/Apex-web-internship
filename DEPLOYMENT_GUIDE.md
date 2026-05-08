# Deployment & Publishing Guide

## Local Deployment (XAMPP)

### Step 1: Copy to XAMPP htdocs
```bash
cd C:\xampp\htdocs
# Copy portfolio folder here
# Make sure you have: index.html, css/, js/, php/, database/, README.md
```

### Step 2: Start XAMPP Services
1. Open XAMPP Control Panel
2. Click "Start" for Apache
3. Click "Start" for MySQL
4. Wait for "Running" status

### Step 3: Import Database
1. Open phpMyAdmin: http://localhost/phpmyadmin
2. Create new database: `portfolio_db`
3. Import: `database/portfolio_db.sql`
4. Verify tables created

### Step 4: Access Website
```
URL: http://localhost/portfolio/
or if in root: http://localhost/
```

### Step 5: Test Functionality
- [ ] Navigate to all sections
- [ ] Test contact form
- [ ] Check phpMyAdmin for stored messages
- [ ] Test responsive design
- [ ] Verify console has no errors

---

## GitHub Publication

### Step 1: Create GitHub Account
1. Go to https://github.com
2. Sign up for free
3. Verify email

### Step 2: Create Repository
1. Click "New" button
2. Name: `portfolio`
3. Description: "Full-stack portfolio website built during Apex internship"
4. Visibility: `Public` (for portfolio showcase)
5. Click "Create repository"

### Step 3: Push to GitHub
```bash
cd C:\path\to\portfolio

# Add remote
git remote add origin https://github.com/YOUR_USERNAME/portfolio.git

# Rename branch (if needed)
git branch -M main

# Push to GitHub
git push -u origin main

# Future pushes
git push
```

### Step 4: Enable GitHub Pages (Optional)
1. Go to Settings → Pages
2. Source: Branch `main`, Folder `/root`
3. Save
4. Wait for deployment
5. Access at: https://YOUR_USERNAME.github.io/portfolio/

**Note**: GitHub Pages serves static files only (HTML, CSS, JS). PHP and MySQL backend won't work.

---

## Web Server Deployment (Production)

### Hosting Options
1. **Shared Hosting**: Bluehost, GoDaddy, Hostinger
2. **VPS**: DigitalOcean, Linode, AWS
3. **PaaS**: Heroku, PythonAnywhere (requires PHP support)

### Recommended: Bluehost (Affiliate of WordPress)

#### Step 1: Purchase Hosting
1. Go to Bluehost.com
2. Choose hosting plan
3. Register domain
4. Complete checkout

#### Step 2: Access cPanel
1. Go to your domain
2. cPanel login credentials sent via email
3. Access at: yoursite.com/cpanel

#### Step 3: Upload Files

**Using FTP:**
```bash
# Download FileZilla (free FTP client)
# Connect with credentials from cPanel
# Upload portfolio files to public_html/
```

**Using cPanel File Manager:**
1. Open cPanel
2. File Manager
3. Navigate to public_html
4. Upload files

#### Step 4: Create Database

In cPanel:
1. Click "MySQL Databases"
2. Create database: `portfolio_db`
3. Create user: `portfolio_user`
4. Add user to database with all privileges
5. Update `php/config.php` with database info

#### Step 5: Verify Deployment
1. Visit: yoursite.com
2. Test contact form
3. Check database in cPanel
4. Fix any errors (check error logs)

---

## Configuration Changes for Production

### Update config.php
```php
<?php
// DEVELOPMENT
// define('DB_HOST', 'localhost');
// define('DB_USER', 'root');
// define('DB_PASS', '');

// PRODUCTION
define('DB_HOST', 'your-hosting-db-host');
define('DB_USER', 'portfolio_user');
define('DB_PASS', 'secure_password_here');
define('DB_NAME', 'portfolio_db');

// Enable error logging
define('DEBUG', false); // false for production
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/errors.log');
?>
```

### SSL Certificate (HTTPS)
1. Most modern hosts include free SSL (Let's Encrypt)
2. Enable in cPanel: AutoSSL
3. Some hosts do automatically
4. Update links in code: http:// → https://

### Content Security Policy
```php
header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline'; style-src 'self' 'unsafe-inline'");
```

---

## Performance on Production

### Optimize Before Deploying
- [ ] Minify CSS and JavaScript
- [ ] Compress images
- [ ] Enable gzip compression
- [ ] Set cache headers
- [ ] Remove debug code

### .htaccess Optimization
```apache
# Enable gzip compression
<IfModule mod_deflate.c>
    AddOutputFilterByType DEFLATE text/plain
    AddOutputFilterByType DEFLATE text/html
    AddOutputFilterByType DEFLATE text/xml
    AddOutputFilterByType DEFLATE text/css
    AddOutputFilterByType DEFLATE text/javascript
    AddOutputFilterByType DEFLATE application/xml
    AddOutputFilterByType DEFLATE application/xhtml+xml
    AddOutputFilterByType DEFLATE application/rss+xml
    AddOutputFilterByType DEFLATE application/javascript
    AddOutputFilterByType DEFLATE application/x-javascript
</IfModule>

# Browser caching
<IfModule mod_expires.c>
    ExpiresActive On
    ExpiresDefault "access plus 2 days"
    ExpiresByType text/html "access plus 2 hours"
    ExpiresByType text/css "access plus 30 days"
    ExpiresByType text/javascript "access plus 30 days"
    ExpiresByType image/jpeg "access plus 60 days"
    ExpiresByType image/png "access plus 60 days"
    ExpiresByType image/gif "access plus 60 days"
</IfModule>

# Redirect HTTP to HTTPS
RewriteEngine On
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]

# Remove .php extension
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^([^\.]+)$ $1.php [NC, L]
```

---

## Monitoring & Maintenance

### Monitor Your Site
1. **Uptime Monitoring**: Pingdom, Uptime Robot
2. **Error Logs**: Check cPanel error logs weekly
3. **Database Backups**: Schedule automatic backups
4. **Security Updates**: Update PHP and MySQL versions

### Database Backups
```bash
# Manual backup
mysqldump -u portfolio_user -p portfolio_db > backup_$(date +%Y%m%d).sql

# Scheduled backup (cron job in cPanel)
# Run daily at 2 AM
0 2 * * * mysqldump -u portfolio_user -p'password' portfolio_db > /home/user/backups/portfolio_$(date +\%Y\%m\%d).sql
```

### Security Checks
- [ ] Change default passwords
- [ ] Remove unnecessary files
- [ ] Keep software updated
- [ ] Monitor suspicious activity
- [ ] Use HTTPS
- [ ] Regular security audits

---

## Troubleshooting Production Issues

### "500 Internal Server Error"
- Check error logs in cPanel
- Verify PHP version compatibility
- Check database connection
- Review .htaccess syntax

### "Database Connection Failed"
- Verify database credentials
- Check database host address
- Ensure database user has permissions
- Restart MySQL service

### Site Too Slow
- Enable caching
- Optimize images
- Minify CSS/JS
- Use CDN for static files
- Upgrade hosting plan

### Forms Not Working
- Check PHP error logs
- Verify form paths
- Test database connection
- Check server mail configuration

---

## Deployment Checklist

Before going live:
- [ ] All files uploaded
- [ ] Database created and populated
- [ ] config.php updated with production credentials
- [ ] .htaccess configured (if needed)
- [ ] SSL certificate installed
- [ ] Error logging enabled
- [ ] Database backups automated
- [ ] Contact form tested
- [ ] All links working
- [ ] Mobile responsive verified
- [ ] Page load time acceptable
- [ ] Security headers set
- [ ] Robots.txt created
- [ ] Sitemap.xml created

---

## Monitoring Tools

| Tool | Purpose |
|------|---------|
| Google Analytics | Visitor tracking |
| Google Search Console | SEO and indexing |
| Uptime Robot | Availability monitoring |
| New Relic | Performance monitoring |
| Cloudflare | CDN and security |

---

## Next Steps

1. ✅ Development complete locally
2. ✅ Testing passed
3. ✅ Documentation prepared
4. → Choose hosting provider
5. → Upload files
6. → Configure database
7. → Test live site
8. → Monitor performance

---

## Keep Learning

After deployment:
- Monitor analytics
- Gather user feedback
- Implement improvements
- Add new features
- Stay updated with technologies
- Contribute to open source
- Build more projects

---

**Deployment Ready**: ✅ Yes  
**Status**: Production-ready  
**Last Updated**: May 8, 2026

# Performance Optimization Guide

## Page Load Performance

### Measure Performance
```javascript
// Measure load time
window.addEventListener('load', function() {
    const perfData = performance.timing;
    const pageLoadTime = perfData.loadEventEnd - perfData.navigationStart;
    console.log('Page load time: ' + pageLoadTime);
});

// Use Performance API
const navigationTiming = performance.getNavigationTiming();
console.log('DOM Content Loaded:', navigationTiming.domContentLoadedEventEnd);
console.log('Page fully loaded:', navigationTiming.loadEventEnd);
```

### Optimize Images
- [ ] Use next-gen formats (WebP, AVIF)
- [ ] Compress images (80% quality is often sufficient)
- [ ] Lazy load images below fold
- [ ] Use responsive images (srcset attribute)

```html
<!-- Responsive image -->
<img srcset="image-small.jpg 480w,
             image-medium.jpg 768w,
             image-large.jpg 1200w"
     sizes="(max-width: 600px) 100vw,
            (max-width: 1200px) 50vw,
            33vw"
     src="image-large.jpg"
     alt="Description">

<!-- Lazy loading -->
<img src="image.jpg" loading="lazy" alt="Description">
```

### Minify & Compress

```bash
# Minify CSS
# Input: css/style.css (45KB)
# Output: css/style.min.css (25KB)

# Minify JavaScript
# Input: js/script.js (32KB)
# Output: js/script.min.js (18KB)

# Gzip compression (server level)
# Reduces files to 20-30% of original size
```

### Critical Rendering Path

1. Parse HTML
2. Load CSS (render blocking)
3. Load JavaScript (parser blocking)
4. Render layout
5. Paint pixels

**Optimization:**
```html
<!-- Non-critical CSS: load async -->
<link rel="stylesheet" href="non-critical.css" media="print" onload="this.media='all'">

<!-- Defer JavaScript -->
<script src="app.js" defer></script>

<!-- Or load at end of body -->
<body>
    <!-- Content -->
    <script src="app.js"></script>
</body>
```

### Caching Strategies

#### Browser Caching
```php
// Cache static assets for 1 month
header("Cache-Control: public, max-age=2592000");

// No cache for HTML
header("Cache-Control: no-cache, no-store, must-revalidate");
```

#### CDN Caching
```html
<!-- Load from CDN instead of origin server -->
<script src="https://cdn.jsdelivr.net/npm/library@version/dist/library.min.js"></script>
```

#### Application Caching
```php
// Cache database queries
$cacheKey = 'projects_list';
$projects = apcu_fetch($cacheKey);
if (!$projects) {
    $projects = $db->query("SELECT * FROM projects");
    apcu_store($cacheKey, $projects, 3600); // Cache 1 hour
}
```

---

## CSS & JavaScript Optimization

### CSS Optimization
- [ ] Remove unused CSS
- [ ] Inline critical CSS
- [ ] Use CSS variables for repeated values
- [ ] Minimize specificity
- [ ] Avoid !important

```css
/* BEFORE: 8KB minified */
.button { padding: 12px 30px; border-radius: 5px; background: #667eea; }
.button-primary { background: #667eea; }
.button-secondary { background: #764ba2; }
.button-disabled { background: #ccc; }

/* AFTER: Using variables (5KB minified) */
:root {
    --btn-primary: #667eea;
    --btn-secondary: #764ba2;
    --btn-disabled: #ccc;
}
.button { background: var(--btn-primary); }
.button-secondary { background: var(--btn-secondary); }
```

### JavaScript Optimization
- [ ] Code splitting
- [ ] Remove unused JavaScript
- [ ] Defer non-critical scripts
- [ ] Use event delegation
- [ ] Debounce/throttle events

```javascript
// BEFORE: Binds listener to every element
document.querySelectorAll('.btn').forEach(btn => {
    btn.addEventListener('click', handleClick);
});

// AFTER: Use event delegation (single listener)
document.addEventListener('click', function(e) {
    if (e.target.matches('.btn')) {
        handleClick(e);
    }
});
```

### Debounce Example
```javascript
// Debounce form validation - only validate after user stops typing
function debounce(fn, wait) {
    let timeout;
    return function(...args) {
        clearTimeout(timeout);
        timeout = setTimeout(() => fn.apply(this, args), wait);
    };
}

const validateEmail = debounce(function() {
    // Validate email
}, 500); // Wait 500ms after typing stops

emailInput.addEventListener('input', validateEmail);
```

---

## Network Performance

### HTTP/2 Push
```html
<!-- Preload resources -->
<link rel="preload" href="font.woff2" as="font" type="font/woff2" crossorigin>
<link rel="preload" href="critical.css" as="style">
```

### Reduce Requests
- [ ] Combine multiple CSS files into one
- [ ] Combine multiple JS files into one
- [ ] Use CSS sprites for icons
- [ ] Use font icon libraries

### Compression
```php
// Enable gzip compression in .htaccess
<IfModule mod_deflate.c>
    AddOutputFilterByType DEFLATE text/html
    AddOutputFilterByType DEFLATE text/plain
    AddOutputFilterByType DEFLATE text/css
    AddOutputFilterByType DEFLATE application/javascript
    AddOutputFilterByType DEFLATE application/json
</IfModule>
```

---

## Database Performance

### Query Optimization
```sql
-- SLOW: Index not used
SELECT * FROM contact_messages WHERE email LIKE '%gmail%';

-- FAST: Use index
SELECT * FROM contact_messages WHERE email = 'user@gmail.com';

-- SLOW: Multiple queries
$contacts = $db->query("SELECT * FROM contacts");
foreach ($contacts as $contact) {
    $messages = $db->query("SELECT * FROM messages WHERE contact_id = " . $contact['id']);
}

-- FAST: Single query with JOIN
SELECT c.*, m.* FROM contacts c
LEFT JOIN messages m ON c.id = m.contact_id;
```

### Connection Pooling
```php
// Reuse database connections
static $conn;
if (!isset($conn)) {
    $conn = mysqli_connect($host, $user, $pass, $db);
}
return $conn;
```

---

## Performance Metrics

### Core Web Vitals
1. **LCP** (Largest Contentful Paint) - < 2.5 seconds
2. **FID** (First Input Delay) - < 100 milliseconds
3. **CLS** (Cumulative Layout Shift) - < 0.1

### Tools
- Google PageSpeed Insights
- WebPageTest
- Chrome DevTools (Lighthouse)
- GTmetrix

### Performance Budget
```
Target:
- HTML: < 100 KB
- CSS: < 50 KB
- JavaScript: < 100 KB
- Images: < 200 KB
- Total page: < 500 KB
- Load time: < 3 seconds
```

---

## Performance Checklist

Before deployment:
- [ ] Images optimized and compressed
- [ ] CSS minified
- [ ] JavaScript minified
- [ ] Unused CSS/JS removed
- [ ] Caching headers set
- [ ] Gzip compression enabled
- [ ] Lazy loading implemented
- [ ] Database queries optimized
- [ ] Lighthouse score > 80
- [ ] Page load time < 3 seconds

---

## Resources

- [Google PageSpeed Insights](https://pagespeed.web.dev/)
- [WebPageTest](https://www.webpagetest.org/)
- [MDN: Web Performance](https://developer.mozilla.org/en-US/docs/Web/Performance)
- [Chrome DevTools: Performance](https://developer.chrome.com/docs/devtools/performance/)

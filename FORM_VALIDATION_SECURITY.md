# Form Validation & Security

## Client-Side Validation (JavaScript)

### HTML Constraints
```html
<input type="email" required>
<input type="text" minlength="2" maxlength="100">
<textarea required minlength="10"></textarea>
```

### JavaScript Validation

```javascript
// Name validation
function validateName(name) {
    return name.trim().length >= 2;
}

// Email validation (regex)
function validateEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

// Subject validation
function validateSubject(subject) {
    return subject.trim().length >= 5;
}

// Message validation
function validateMessage(message) {
    return message.trim().length >= 10;
}
```

### Real-Time Validation
```javascript
// Validate on blur (when user leaves field)
input.addEventListener('blur', function() {
    if (!validateEmail(this.value)) {
        showError('Email must be valid');
    }
});

// Clear error on input (as user types)
input.addEventListener('input', function() {
    if (validateEmail(this.value)) {
        clearError();
    }
});
```

### Error Display
```html
<div class="form-group">
    <label for="email">Email</label>
    <input type="email" id="email" name="email" required>
    <span class="error-message" id="emailError"></span>
</div>
```

```css
.error-message {
    color: #e74c3c;
    font-size: 0.875rem;
    display: none;
}

.error-message.show {
    display: block;
}
```

---

## Server-Side Validation (PHP)

### Must ALWAYS validate server-side!
Client-side validation can be bypassed.

```php
// Check input exists
if (empty($_POST['name'])) {
    return 'Name is required';
}

// Check length
if (strlen($_POST['name']) < 2) {
    return 'Name must be at least 2 characters';
}

// Email validation
if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    return 'Invalid email address';
}

// String length
if (strlen($_POST['subject']) < 5) {
    return 'Subject must be at least 5 characters';
}
```

---

## Data Sanitization

### XSS Prevention (htmlspecialchars)
```php
// Prevents malicious scripts
$name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
// <script> becomes &lt;script&gt;
```

### SQL Injection Prevention (Prepared Statements)
```php
// GOOD: Prepared statement
$stmt = $conn->prepare("INSERT INTO contact (name) VALUES (?)");
$stmt->bind_param("s", $name);
$stmt->execute();

// BAD: Direct concatenation (vulnerable)
$query = "INSERT INTO contact (name) VALUES ('" . $_POST['name'] . "')";
// This allows: ' OR '1'='1
```

### Email Sanitization
```php
$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
```

---

## Common Attack Vectors

### 1. SQL Injection
**Attack**: `' OR '1'='1`
**Prevention**: 
- Use prepared statements
- Never concatenate user input into SQL
- Use parameterized queries

### 2. XSS (Cross-Site Scripting)
**Attack**: `<script>alert('XSS')</script>`
**Prevention**:
- Use htmlspecialchars() for output
- Use htmlentities() for HTML content
- Sanitize all user input

### 3. CSRF (Cross-Site Request Forgery)
**Attack**: Hidden form submission from other site
**Prevention**:
- Use CSRF tokens
- Validate referer header
- Use SameSite cookies

### 4. Data Validation Bypass
**Attack**: Remove JavaScript validation, send bad data
**Prevention**:
- Always validate server-side
- Never trust client-side validation alone
- Validate data type and length

---

## Validation Checklist

- [ ] Client-side validation for UX
- [ ] Server-side validation for security
- [ ] Email validation (format and optional confirmation)
- [ ] Length validation (min/max)
- [ ] Type validation (string, number, etc.)
- [ ] Required field validation
- [ ] XSS prevention (htmlspecialchars)
- [ ] SQL injection prevention (prepared statements)
- [ ] Error messages don't reveal system info
- [ ] Rate limiting on submissions

---

## Best Practices

1. **Always validate server-side** - Client validation is for UX only
2. **Sanitize all input** - Treat all user input as potentially malicious
3. **Use prepared statements** - Prevent SQL injection
4. **Encode output** - When displaying user input
5. **Clear error messages** - Help users, not attackers
6. **Log errors** - For debugging and security audit
7. **Use HTTPS** - Encrypt data in transit
8. **Rate limiting** - Prevent spam/DoS attacks
9. **Keep dependencies updated** - Security patches

---

## Validation Rules Summary

| Field | Required | Min Length | Max Length | Format |
|-------|----------|-----------|-----------|--------|
| Name | Yes | 2 | 100 | Text only |
| Email | Yes | 5 | 100 | Valid email |
| Subject | Yes | 5 | 200 | Text |
| Message | Yes | 10 | 5000 | Text |

---

## GDPR Compliance Tips

1. Get user consent before storing data
2. Store only necessary information
3. Allow user to request data deletion
4. Encrypt sensitive data
5. Have clear privacy policy
6. Document data retention period

---

## Resources

- [OWASP: Form Validation](https://owasp.org/www-community/controls/Input_Validation)
- [MDN: Form Validation](https://developer.mozilla.org/en-US/docs/Learn/Forms/Form_validation)
- [PHP: Filter Functions](https://www.php.net/manual/en/filter.filters.php)

# Testing Guide

## Frontend Testing

### HTML Structure
- [ ] Validate HTML using W3C Validator
- [ ] Check semantic markup (header, nav, section, article, footer)
- [ ] Verify form elements (input, textarea, label)
- [ ] Test form accessibility with screen reader

### CSS Responsive Design
- [ ] Desktop (1200px+): All layouts visible, 3-column grids
- [ ] Tablet (768px-1199px): Adjusted spacing, 2-column grids
- [ ] Mobile (480px-767px): Single column, hamburger menu
- [ ] Extra small (<480px): Minimal layout, stacked elements
- [ ] Verify font sizes scale properly
- [ ] Check color contrast for accessibility

### JavaScript Functionality
- [ ] Navigation links scroll smoothly
- [ ] Hamburger menu toggles on click
- [ ] Menu closes when link clicked
- [ ] Form inputs show error on blur
- [ ] Form validates all required fields
- [ ] Success message appears after submission

## Backend Testing

### PHP Form Processing
- [ ] Submit empty form → shows error
- [ ] Enter invalid email → shows email error
- [ ] Short name/message → shows length error
- [ ] Valid form → success message displays
- [ ] Check browser console for errors
- [ ] View network tab → successful POST to contact.php

### Database Testing
1. Open phpMyAdmin: http://localhost/phpmyadmin
2. Select portfolio_db database
3. View contact_messages table
4. Submit form on website
5. Refresh table → new message appears

### MySQL Queries
```sql
-- Test SELECT
SELECT * FROM contact_messages;

-- Test UPDATE
UPDATE contact_messages SET is_read = TRUE WHERE id = 1;

-- Test DELETE
DELETE FROM contact_messages WHERE id = 1;

-- Verify data
SELECT COUNT(*) FROM contact_messages;
```

## End-to-End Testing Checklist

- [ ] Website loads without errors (F12 console)
- [ ] All images display correctly
- [ ] Navigation works on all device sizes
- [ ] Form validation prevents empty submissions
- [ ] Form submission saves to database
- [ ] Messages appear in phpMyAdmin
- [ ] Responsive design works (resize browser)
- [ ] Mobile menu display/hide works
- [ ] CSS animations visible (hover effects)
- [ ] JavaScript console clear (no errors)

## Performance Testing

### Page Load
- [ ] Load time < 3 seconds
- [ ] No 404 errors in network tab
- [ ] All CSS, JS, images cached

### Form Performance
- [ ] Real-time validation doesn't lag
- [ ] Form submission completes in < 2 seconds
- [ ] No duplicate submissions

## Browser Compatibility
- [ ] Chrome/Chromium
- [ ] Firefox
- [ ] Safari
- [ ] Edge
- [ ] Mobile Safari (iOS)
- [ ] Chrome Mobile (Android)

## Accessibility Testing
- [ ] Tab navigation works
- [ ] Form labels associated with inputs
- [ ] Error messages clear and descriptive
- [ ] Color contrast meets WCAG standards (>4.5:1)
- [ ] Screen reader compatible

## Security Testing
- [ ] SQL injection attempt (e.g., name: ' OR '1'='1) → blocked
- [ ] XSS attempt (e.g., message with <script>) → escaped
- [ ] CSRF protection (optional)
- [ ] Email validation prevents spam

## Troubleshooting Common Issues

### "Connection Refused"
- Ensure XAMPP Apache and MySQL are running
- Check Services for Apache and MySQL startup

### Form Not Submitting
- Check browser console (F12) for JavaScript errors
- Verify php/contact.php file exists
- Check network tab for failed POST request

### Database Not Working
- Verify portfolio_db exists in phpMyAdmin
- Ensure contact_messages and other tables exist
- Check php/config.php database credentials

### CSS/JS Not Loading
- Check file paths (relative URLs)
- Clear browser cache (Ctrl+Shift+Delete)
- Verify file names match exactly (case-sensitive on Unix)

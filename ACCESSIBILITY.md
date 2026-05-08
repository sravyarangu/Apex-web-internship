# Accessibility (A11Y) Best Practices

## What is Accessibility?

Making websites usable for everyone, including people with disabilities:
- Visual impairments (blindness, color blindness)
- Hearing impairments (deafness, hard of hearing)
- Motor disabilities (unable to use mouse)
- Cognitive disabilities (dyslexia, ADHD)
- Temporary disabilities (broken arm, bright sunlight)

## Semantic HTML5

### Proper Structure
```html
<!-- GOOD: Semantic HTML -->
<header>
    <nav>Navigation</nav>
</header>
<main>
    <article>
        <h1>Page Title</h1>
        <section>Content</section>
    </article>
</main>
<footer>Footer</footer>

<!-- BAD: Using only divs -->
<div class="header">
    <div class="navbar">Navigation</div>
</div>
```

### Benefits
- Screen readers better understand page structure
- Better SEO
- More maintainable code
- Improves mobile layout

---

## ARIA Attributes

### Use ARIA to support accessibility

```html
<!-- Label form inputs -->
<label for="email">Email</label>
<input type="email" id="email" name="email">

<!-- Describe interactive elements -->
<button aria-label="Close menu">×</button>

<!-- Add helpful descriptions -->
<img src="user.jpg" alt="Profile picture of John Doe">

<!-- Mark regions -->
<nav aria-label="Main navigation">
    <a href="#home">Home</a>
</nav>

<!-- Loading state -->
<div role="status" aria-live="polite">Saving...</div>

<!-- Hide decorative elements -->
<span aria-hidden="true">→</span>
```

### Common ARIA Roles
```html
<div role="alert">Error message</div>
<div role="status">Status updates</div>
<nav role="navigation">Navigation area</nav>
<main role="main">Main content</main>
<aside role="complementary">Sidebar content</aside>
```

---

## Color Contrast

### WCAG Standards
- **AA Level**: 4.5:1 contrast ratio (minimum)
- **AAA Level**: 7:1 contrast ratio (enhanced)

### Check Contrast
```
Black (#000) on White (#FFF): 21:1 ✓ Perfect
Dark Blue (#003366) on Light Gray (#EAEAEA): 7.8:1 ✓ Good
Gray (#777) on Light Gray (#EEE): 2:1 ✗ Too low
```

### Tools
- WebAIM Contrast Checker
- Chrome DevTools (Inspect element → Accessibility panel)
- Color Contrast Analyzer

---

## Keyboard Navigation

### Make Everything Keyboard Accessible
```html
<!-- Use proper semantic elements for keyboard support -->
<button>Click me</button> <!-- Good: Built-in keyboard support -->
<a href="/">Link</a>     <!-- Good: Built-in keyboard support -->

<!-- Avoid these -->
<div onclick="doSomething()">Click</div> <!-- Bad: No keyboard support -->
<span role="button">Click</span>          <!-- Bad: No keyboard by default -->
```

### Tab Order
```css
/* Control focus visible -->
:focus {
    outline: 2px solid #667eea;
    outline-offset: 2px;
}

:focus-visible {
    outline: 2px solid #667eea;
}
```

```html
<!-- Custom tab order (use sparingly) -->
<input type="text" tabindex="1">
<input type="text" tabindex="2">
<input type="text" tabindex="0"> <!-- Comes after tab-indexed items -->

<!-- Remove from tab order -->
<span tabindex="-1">Not tabbable</span>
```

### Skip Navigation
```html
<!-- Allow users to skip to main content -->
<a href="#main" class="skip-link">Skip to main content</a>

<main id="main">
    <!-- Main content -->
</main>

<style>
.skip-link {
    position: absolute;
    top: -40px;
    left: 0;
    background: #667eea;
    color: white;
    padding: 8px;
    text-decoration: none;
    z-index: 100;
}

.skip-link:focus {
    top: 0;
}
</style>
```

---

## Form Accessibility

### Proper Label Association
```html
<!-- GOOD: Associated label -->
<label for="email">Email</label>
<input type="email" id="email" name="email">

<!-- GOOD: Label wrapping input -->
<label>
    Email
    <input type="email" name="email">
</label>

<!-- BAD: Unassociated label -->
<label>Email</label>
<input type="email">
```

### Error Messages
```html
<!-- Associate error with field -->
<label for="email">Email</label>
<input type="email" id="email" aria-describedby="email-error">
<span id="email-error" role="alert">Invalid email format</span>

<!-- Or use aria-invalid -->
<input type="email" aria-invalid="true" aria-describedby="error">
<span id="error">Please enter valid email</span>
```

---

## Image Alt Text

### Descriptive Alt Text
```html
<!-- GOOD: Descriptive -->
<img src="team.jpg" alt="Team of 5 developers collaborating at desk">

<!-- BAD: Vague -->
<img src="team.jpg" alt="image">

<!-- BAD: Redundant -->
<a href="/team"><img src="team.jpg" alt="Team photo"><br>Team</a>
<!-- Better: <a href="/team"><img src="team.jpg" alt=""><br>Team</a> -->
```

### Icons
```html
<!-- Icon needs text alternative -->
<button aria-label="Close menu">×</button>

<!-- Or with hidden text -->
<button><span aria-hidden="true">×</span> <span class="sr-only">Close</span></button>

<!-- Screen reader only text -->
<style>
.sr-only {
    position: absolute;
    width: 1px;
    height: 1px;
    padding: 0;
    margin: -1px;
    overflow: hidden;
    clip: rect(0,0,0,0);
    white-space: nowrap;
    border-width: 0;
}
</style>
```

---

## Text & Readability

### Font Size
- Minimum: 14px (16px recommended)
- Line height: 1.5 or greater
- Letter spacing: 0.12em or 2% of font size

### Line Length
- Maximum: 80 characters per line
- Optimal: 45-75 characters per line

### Text Formatting
```html
<!-- Use semantic elements -->
<strong>Important</strong>      <!-- Semantic emphasis -->
<em>Emphasized</em>             <!-- Semantic emphasis -->
<b>Bold</b>                     <!-- Styling only -->
<i>Italic</i>                   <!-- Styling only -->

<!-- Use proper heading hierarchy -->
<h1>Page Title</h1>
<h2>Section Title</h2>
<h3>Subsection Title</h3>

<!-- Avoid skipping heading levels -->
<!-- DON'T: <h1>Title</h1><h3>Subsection</h3> -->
<!-- DO: <h1>Title</h1><h2>Section</h2><h3>Subsection</h3> -->
```

---

## Video & Multimedia

### Captions
```html
<video controls>
    <source src="video.mp4" type="video/mp4">
    <track kind="captions" src="captions.vtt" srclang="en">
</video>
```

### ARIA Live Regions
```html
<!-- Content that updates should announce changes -->
<div aria-live="polite" aria-atomic="true">
    <!-- Updates announced to screen readers -->
</div>
```

---

## Testing Accessibility

### Manual Testing
- [ ] Use keyboard only (no mouse)
- [ ] Test with screen reader (NVDA, JAWS, VoiceOver)
- [ ] Check color contrast
- [ ] Verify tab order makes sense
- [ ] Test form with/without labels
- [ ] Check alt text on images

### Automated Tools
- WAVE (WebAIM)
- axe DevTools
- Lighthouse (Chrome)
- NVDA Screen Reader (free)
- ChromeVox (Chrome extension)

---

## Accessibility Checklist

- [ ] Proper semantic HTML structure
- [ ] All images have descriptive alt text
- [ ] Forms have associated labels
- [ ] Color contrast meets WCAG AA (4.5:1)
- [ ] Keyboard navigation works (Tab, Enter, Escape)
- [ ] Focus indicators visible
- [ ] Error messages clear and associated with inputs
- [ ] No auto-playing audio/video
- [ ] ARIA attributes used correctly
- [ ] Lighthouse accessibility score > 90
- [ ] Tested with screen reader
- [ ] Text is resizable (no fixed px units)

---

## WCAG Compliance Levels

- **A**: Basic compliance (minimum)
- **AA**: Enhanced compliance (recommended)
- **AAA**: Maximum compliance (aspiring)

**Target: WCAG 2.1 Level AA**

---

## Resources

- [WCAG Guidelines](https://www.w3.org/WAI/WCAG21/quickref/)
- [MDN: Accessibility](https://developer.mozilla.org/en-US/docs/Web/Accessibility)
- [WebAIM](https://webaim.org/)
- [NVDA Screen Reader](https://www.nvaccess.org/)
- [ARIA Authoring Practices](https://www.w3.org/WAI/ARIA/apg/)

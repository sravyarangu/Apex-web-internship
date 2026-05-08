/* ========================================
   PORTFOLIO WEBSITE - JAVASCRIPT
   DOM Manipulation, Event Handling, Form Validation
   ======================================== */

// ========================================
// MOBILE MENU TOGGLE
// ========================================

document.addEventListener('DOMContentLoaded', function() {
    const hamburger = document.querySelector('.hamburger');
    const navMenu = document.querySelector('.nav-menu');
    const navLinks = document.querySelectorAll('.nav-link');

    // Toggle mobile menu on hamburger click
    hamburger.addEventListener('click', function() {
        navMenu.classList.toggle('active');
        hamburger.classList.toggle('active');
    });

    // Close menu when a link is clicked
    navLinks.forEach(link => {
        link.addEventListener('click', function() {
            navMenu.classList.remove('active');
            hamburger.classList.remove('active');
        });
    });

    // ========================================
    // CONTACT FORM VALIDATION
    // ========================================

    const contactForm = document.getElementById('contactForm');
    const successMessage = document.getElementById('successMessage');

    if (contactForm) {
        contactForm.addEventListener('submit', function(event) {
            event.preventDefault();

            // Clear previous error messages and success message
            clearAllErrors();
            successMessage.classList.remove('show');
            successMessage.textContent = '';

            // Get form values
            const name = document.getElementById('name').value.trim();
            const email = document.getElementById('email').value.trim();
            const subject = document.getElementById('subject').value.trim();
            const message = document.getElementById('message').value.trim();

            // Validate form
            let isValid = true;

            if (!validateName(name)) {
                showError('nameError', 'Please enter a valid name (at least 2 characters)');
                isValid = false;
            }

            if (!validateEmail(email)) {
                showError('emailError', 'Please enter a valid email address');
                isValid = false;
            }

            if (!validateSubject(subject)) {
                showError('subjectError', 'Please enter a subject (at least 5 characters)');
                isValid = false;
            }

            if (!validateMessage(message)) {
                showError('messageError', 'Please enter a message (at least 10 characters)');
                isValid = false;
            }

            if (isValid) {
                // Prepare form data
                const formData = new FormData();
                formData.append('name', name);
                formData.append('email', email);
                formData.append('subject', subject);
                formData.append('message', message);

                // Send data to PHP backend
                fetch('php/contact.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        successMessage.textContent = '✓ Message sent successfully! We\'ll get back to you soon.';
                        successMessage.classList.add('show');
                        contactForm.reset();

                        // Hide success message after 5 seconds
                        setTimeout(function() {
                            successMessage.classList.remove('show');
                        }, 5000);
                    } else {
                        successMessage.textContent = 'Error: ' + data.message;
                        successMessage.style.color = '#e74c3c';
                        successMessage.classList.add('show');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    successMessage.textContent = 'Error sending message. Please try again later.';
                    successMessage.style.color = '#e74c3c';
                    successMessage.classList.add('show');
                });
            }
        });
    }

    // ========================================
    // FORM VALIDATION FUNCTIONS
    // ========================================

    function validateName(name) {
        return name.length >= 2;
    }

    function validateEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    function validateSubject(subject) {
        return subject.length >= 5;
    }

    function validateMessage(message) {
        return message.length >= 10;
    }

    function showError(elementId, message) {
        const errorElement = document.getElementById(elementId);
        errorElement.textContent = message;
        errorElement.classList.add('show');
    }

    function clearAllErrors() {
        const errorElements = document.querySelectorAll('.error-message');
        errorElements.forEach(element => {
            element.classList.remove('show');
            element.textContent = '';
        });
    }

    // ========================================
    // REAL-TIME INPUT VALIDATION
    // ========================================

    const nameInput = document.getElementById('name');
    const emailInput = document.getElementById('email');
    const subjectInput = document.getElementById('subject');
    const messageInput = document.getElementById('message');

    if (nameInput) {
        nameInput.addEventListener('blur', function() {
            if (this.value.trim() && !validateName(this.value.trim())) {
                showError('nameError', 'Please enter at least 2 characters');
            } else {
                clearErrorFor('nameError');
            }
        });

        nameInput.addEventListener('input', function() {
            if (this.value.trim() && validateName(this.value.trim())) {
                clearErrorFor('nameError');
            }
        });
    }

    if (emailInput) {
        emailInput.addEventListener('blur', function() {
            if (this.value.trim() && !validateEmail(this.value.trim())) {
                showError('emailError', 'Please enter a valid email address');
            } else {
                clearErrorFor('emailError');
            }
        });

        emailInput.addEventListener('input', function() {
            if (this.value.trim() && validateEmail(this.value.trim())) {
                clearErrorFor('emailError');
            }
        });
    }

    if (subjectInput) {
        subjectInput.addEventListener('blur', function() {
            if (this.value.trim() && !validateSubject(this.value.trim())) {
                showError('subjectError', 'Please enter at least 5 characters');
            } else {
                clearErrorFor('subjectError');
            }
        });

        subjectInput.addEventListener('input', function() {
            if (this.value.trim() && validateSubject(this.value.trim())) {
                clearErrorFor('subjectError');
            }
        });
    }

    if (messageInput) {
        messageInput.addEventListener('blur', function() {
            if (this.value.trim() && !validateMessage(this.value.trim())) {
                showError('messageError', 'Please enter at least 10 characters');
            } else {
                clearErrorFor('messageError');
            }
        });

        messageInput.addEventListener('input', function() {
            if (this.value.trim() && validateMessage(this.value.trim())) {
                clearErrorFor('messageError');
            }
        });
    }

    function clearErrorFor(elementId) {
        const errorElement = document.getElementById(elementId);
        errorElement.classList.remove('show');
        errorElement.textContent = '';
    }

    // ========================================
    // SMOOTH SCROLL FOR NAVIGATION
    // ========================================

    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const href = this.getAttribute('href');
            if (href !== '#' && document.querySelector(href)) {
                e.preventDefault();
                const target = document.querySelector(href);
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // ========================================
    // SCROLL ANIMATIONS
    // ========================================

    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -100px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.animation = 'fadeIn 0.6s ease forwards';
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    document.querySelectorAll('.project-card, .skill-item, .stat').forEach(element => {
        observer.observe(element);
    });

    // ========================================
    // FORM AUTO-FOCUS MANAGEMENT
    // ========================================

    const formInputs = document.querySelectorAll('input, textarea');
    formInputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.style.boxShadow = '0 0 10px rgba(102, 126, 234, 0.3)';
        });

        input.addEventListener('blur', function() {
            this.style.boxShadow = 'none';
        });
    });

    // ========================================
    // PREVENT FORM RESUBMISSION
    // ========================================

    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
});

// ========================================
// UTILITY: LOG PORTFOLIO LOADED
// ========================================

console.log('Portfolio website loaded successfully!');
console.log('Technologies used: HTML5, CSS3, JavaScript, PHP, MySQL');

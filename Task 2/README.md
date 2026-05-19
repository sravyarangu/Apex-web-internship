# Frontend UI Demo — Login & Registration

This demo provides a responsive Login and Registration UI built with Bootstrap 5, client-side validation, a show/hide password toggle, password-match check, and a dummy AJAX username availability check.

Files created:
- `index.html` — main demo
- `assets/css/styles.css` — custom styles
- `assets/js/main.js` — client-side behavior
- `check_username.php` — PHP stub returning JSON (dummy)

Run locally (static demo):

1) Using Python static server (no PHP endpoint):

```powershell
cd "c:\Users\Sravya Rangu\OneDrive\Documents\Apex internship web development\Task 2"
python -m http.server 8000
```

Open http://localhost:8000 in your browser. The username check will use a local fallback when `check_username.php` is not available.

2) To run with the PHP stub (if PHP is installed):

```powershell
cd "c:\Users\Sravya Rangu\OneDrive\Documents\Apex internship web development\Task 2"
php -S localhost:8000
```

Open http://localhost:8000/index.html — the username availability call will reach `check_username.php`.

Notes:
- The demo uses Bootstrap CDN for convenience. If you prefer offline assets, let me know and I will vendor them into the project.

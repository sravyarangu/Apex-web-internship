# Backend Development & Database Integration

This project is a small PHP/MySQL user management system built for the backend task in the screenshot. It covers registration, login, role-based access, CRUD, profile editing, and profile-picture uploads.

## What the app does

- Registers users with hashed passwords.
- Lets users log in and log out using sessions.
- Shows different behavior for `Admin` and `User` roles.
- Lets admins create and delete users.
- Lets signed-in users update their own profile.
- Supports profile picture uploads with file-type and size checks.
- Uses prepared statements for all database writes and lookups.

## How the pieces fit together

- `database/schema.sql` creates the `roles` and `users` tables and seeds `Admin` and `User`.
- `includes/db.php` opens the MySQL connection.
- `includes/auth.php` manages sessions and access control.
- `includes/user_repository.php` contains the database queries for users and roles.
- `includes/upload.php` validates and stores profile images.
- `public/index.php` is the single entry point that renders the forms and handles form submissions.

## Database model

### `roles`

- `id`: primary key.
- `name`: role name such as `Admin` or `User`.
- `created_at`: timestamp.

### `users`

- `id`: primary key.
- `role_id`: links each user to a role.
- `full_name`: user’s display name.
- `email`: unique login identifier.
- `password_hash`: hashed password, never stored as plain text.
- `phone`: optional phone number.
- `profile_picture`: relative path to uploaded image.
- `created_at` and `updated_at`: timestamps.

## Main flows

### Registration

1. Open the homepage.
2. Fill in the registration form.
3. Choose a role and optionally upload a profile image.
4. The app checks whether the email already exists.
5. The password is saved with `password_hash()`.
6. If an image is uploaded, it must be JPG, PNG, or WEBP and no larger than 2 MB.

### Login and logout

1. Enter email and password in the login form.
2. The app loads the user from the database and verifies the password with `password_verify()`.
3. On success, a session is created.
4. Logout clears the session.

### Profile management

- Logged-in users can update their own name, email, phone, password, and profile picture.
- Leaving the password blank keeps the current password.
- If a new picture is uploaded, it is stored in `public/uploads`.

### Admin CRUD

- Admins can add new users from the dashboard.
- Admins can delete users from the user table.
- Admin-only actions are protected by `requireAdmin()`.

## How to run it

### 1. Make sure MySQL is running

The app expects a local MySQL server. In this workspace it was tested with:

- host: `127.0.0.1`
- username: `root`
- password: `dbms`
- database: `apex_task3`

### 2. Load the schema

Run the schema against the selected database:

```powershell
& 'C:\Program Files\MySQL\MySQL Server 8.0\bin\mysql.exe' -h 127.0.0.1 -u root -pdbms apex_task3 -e "source C:/Users/Sravya Rangu/OneDrive/Documents/Apex internship web development/Task 3/database/schema.sql"
```

### 3. Start PHP with the local config

This project uses a local `php.ini` in the workspace so the CLI and built-in server can load `mysqli`, `pdo_mysql`, and `fileinfo`.

```powershell
$env:PHPRC='C:\Users\Sravya Rangu\OneDrive\Documents\Apex internship web development\Task 3'
php -S localhost:8000 -t public
```

### 4. Open the app

Visit:

```text
http://localhost:8000
```

## Suggested test accounts

- Admin: register a user with role `Admin`.
- Regular user: register a user with role `User`.

## Troubleshooting

- If you see `Call to undefined function mysqli_report()`, PHP is missing the `mysqli` extension or the correct `php.ini` is not being loaded.
- If you see `Class "finfo" not found`, enable the `fileinfo` extension.
- If login fails with `Access denied`, check the MySQL password in `includes/db.php`.
- If uploads fail, confirm `public/uploads` exists and is writable.

## Important implementation notes

- Passwords are hashed; the app never stores plain-text passwords.
- Database reads and writes use prepared statements.
- Uploaded images are validated by MIME type and file size.
- The project currently uses a hard-coded DB password in `includes/db.php` for the local setup.

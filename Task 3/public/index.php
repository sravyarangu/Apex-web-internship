<?php

declare(strict_types=1);

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/user_repository.php';
require_once __DIR__ . '/../includes/upload.php';

ensureSessionStarted();

$view = $_GET['view'] ?? 'dashboard';
$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $action = $_POST['action'] ?? '';

        if ($action === 'register') {
            $existing = fetchUserByEmail(trim((string) $_POST['email']));
            if ($existing) {
                throw new RuntimeException('Email already exists.');
            }

            $profilePicture = handleProfileUpload($_FILES['profile_picture'] ?? []);
            $roleId = (int) ($_POST['role_id'] ?? 2);

            createUser([
                'role_id' => $roleId,
                'full_name' => trim((string) $_POST['full_name']),
                'email' => trim((string) $_POST['email']),
                'password_hash' => password_hash((string) $_POST['password'], PASSWORD_DEFAULT),
                'phone' => trim((string) ($_POST['phone'] ?? '')) ?: null,
                'profile_picture' => $profilePicture,
            ]);

            $message = 'Registration successful. You can log in now.';
            $view = 'login';
        } elseif ($action === 'login') {
            $user = fetchUserByEmail(trim((string) $_POST['email']));
            if (!$user || !password_verify((string) $_POST['password'], $user['password_hash'])) {
                throw new RuntimeException('Invalid login details.');
            }

            loginUser($user);
            header('Location: /index.php');
            exit;
        } elseif ($action === 'logout') {
            logoutUser();
            header('Location: /index.php?view=login');
            exit;
        } elseif ($action === 'create_user') {
            requireAdmin();
            $profilePicture = handleProfileUpload($_FILES['profile_picture'] ?? []);

            createUser([
                'role_id' => (int) $_POST['role_id'],
                'full_name' => trim((string) $_POST['full_name']),
                'email' => trim((string) $_POST['email']),
                'password_hash' => password_hash((string) $_POST['password'], PASSWORD_DEFAULT),
                'phone' => trim((string) ($_POST['phone'] ?? '')) ?: null,
                'profile_picture' => $profilePicture,
            ]);

            $message = 'User created successfully.';
        } elseif ($action === 'update_user') {
            requireAdmin();
            $id = (int) $_POST['id'];
            $existingUser = fetchUserById($id);
            if (!$existingUser) {
                throw new RuntimeException('User not found.');
            }

            $profilePicture = handleProfileUpload($_FILES['profile_picture'] ?? []);
            updateUser($id, [
                'role_id' => (int) $_POST['role_id'],
                'full_name' => trim((string) $_POST['full_name']),
                'email' => trim((string) $_POST['email']),
                'phone' => trim((string) ($_POST['phone'] ?? '')) ?: null,
                'profile_picture' => $profilePicture,
            ]);

            if (!empty($_POST['password'])) {
                updatePassword($id, password_hash((string) $_POST['password'], PASSWORD_DEFAULT));
            }

            $message = 'User updated successfully.';
        } elseif ($action === 'delete_user') {
            requireAdmin();
            deleteUser((int) $_POST['id']);
            $message = 'User deleted successfully.';
        } elseif ($action === 'update_profile') {
            requireLogin();
            $userId = currentUserId();
            $currentProfile = fetchUserById($userId);
            $profilePicture = handleProfileUpload($_FILES['profile_picture'] ?? []);

            updateUser($userId, [
                'role_id' => (int) ($currentProfile['role_id'] ?? ($_SESSION['role_id'] ?? 2)),
                'full_name' => trim((string) $_POST['full_name']),
                'email' => trim((string) $_POST['email']),
                'phone' => trim((string) ($_POST['phone'] ?? '')) ?: null,
                'profile_picture' => $profilePicture,
            ]);

            if (!empty($_POST['password'])) {
                updatePassword($userId, password_hash((string) $_POST['password'], PASSWORD_DEFAULT));
            }

            $message = 'Profile updated successfully.';
        }
    } catch (Throwable $throwable) {
        $error = $throwable->getMessage();
    }
}

$loggedInUser = null;
if (currentUserId() !== null) {
    $loggedInUser = fetchUserById(currentUserId());
}

$users = fetchUsers();
$roles = fetchRoles();
?><!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Apex Task 3 Backend</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; background: #f4f7fb; color: #1f2937; }
        header { background: #0f766e; color: white; padding: 20px; }
        main { max-width: 1100px; margin: 0 auto; padding: 24px; }
        .card { background: white; border-radius: 14px; padding: 20px; box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08); margin-bottom: 20px; }
        .grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 16px; }
        input, select, button { width: 100%; padding: 10px 12px; margin-top: 8px; box-sizing: border-box; }
        button { background: #0f766e; color: white; border: none; border-radius: 10px; cursor: pointer; }
        table { width: 100%; border-collapse: collapse; }
        th, td { text-align: left; padding: 10px; border-bottom: 1px solid #e5e7eb; vertical-align: top; }
        .message { color: #065f46; }
        .error { color: #b91c1c; }
        img.avatar { width: 56px; height: 56px; object-fit: cover; border-radius: 999px; }
        .actions { display: flex; gap: 8px; flex-wrap: wrap; }
        .actions form { display: inline; }
        .small { font-size: 0.9rem; color: #6b7280; }
    </style>
</head>
<body>
<header>
    <h1>Backend Development & Database Integration</h1>
    <p class="small">PHP, MySQL, authentication, CRUD, role-based access, and profile management.</p>
</header>
<main>
    <?php if ($message !== ''): ?>
        <div class="card message"><?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?></div>
    <?php endif; ?>

    <?php if ($error !== ''): ?>
        <div class="card error"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></div>
    <?php endif; ?>

    <?php if (currentUserId() === null): ?>
        <div class="grid">
            <div class="card">
                <h2>Login</h2>
                <form method="post">
                    <input type="hidden" name="action" value="login">
                    <label>Email<input type="email" name="email" required></label>
                    <label>Password<input type="password" name="password" required></label>
                    <button type="submit">Login</button>
                </form>
            </div>
            <div class="card">
                <h2>Register</h2>
                <form method="post" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="register">
                    <label>Full Name<input type="text" name="full_name" required></label>
                    <label>Email<input type="email" name="email" required></label>
                    <label>Password<input type="password" name="password" required></label>
                    <label>Phone<input type="text" name="phone"></label>
                    <label>Role
                        <select name="role_id">
                            <?php foreach ($roles as $role): ?>
                                <option value="<?php echo (int) $role['id']; ?>"><?php echo htmlspecialchars($role['name'], ENT_QUOTES, 'UTF-8'); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                    <label>Profile Picture<input type="file" name="profile_picture" accept="image/*"></label>
                    <button type="submit">Create Account</button>
                </form>
            </div>
        </div>
    <?php else: ?>
        <div class="card">
            <div class="actions" style="justify-content: space-between; align-items: center;">
                <div>
                    <strong>Signed in as:</strong> <?php echo htmlspecialchars((string) ($_SESSION['full_name'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>
                    <span class="small">(<?php echo htmlspecialchars((string) ($_SESSION['role_name'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>)</span>
                </div>
                <form method="post">
                    <input type="hidden" name="action" value="logout">
                    <button type="submit">Logout</button>
                </form>
            </div>
        </div>

        <div class="grid">
            <div class="card">
                <h2>Profile Management</h2>
                <form method="post" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="update_profile">
                    <label>Full Name<input type="text" name="full_name" value="<?php echo htmlspecialchars((string) ($loggedInUser['full_name'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>" required></label>
                    <label>Email<input type="email" name="email" value="<?php echo htmlspecialchars((string) ($loggedInUser['email'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>" required></label>
                    <label>Phone<input type="text" name="phone" value="<?php echo htmlspecialchars((string) ($loggedInUser['phone'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>"></label>
                    <label>New Password<input type="password" name="password" placeholder="Leave blank to keep current password"></label>
                    <label>Profile Picture<input type="file" name="profile_picture" accept="image/*"></label>
                    <button type="submit">Update Profile</button>
                </form>
            </div>

            <?php if (($_SESSION['role_name'] ?? '') === 'Admin'): ?>
                <div class="card">
                    <h2>Add User</h2>
                    <form method="post" enctype="multipart/form-data">
                        <input type="hidden" name="action" value="create_user">
                        <label>Full Name<input type="text" name="full_name" required></label>
                        <label>Email<input type="email" name="email" required></label>
                        <label>Password<input type="password" name="password" required></label>
                        <label>Phone<input type="text" name="phone"></label>
                        <label>Role
                            <select name="role_id">
                                <?php foreach ($roles as $role): ?>
                                    <option value="<?php echo (int) $role['id']; ?>"><?php echo htmlspecialchars($role['name'], ENT_QUOTES, 'UTF-8'); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </label>
                        <label>Profile Picture<input type="file" name="profile_picture" accept="image/*"></label>
                        <button type="submit">Save User</button>
                    </form>
                </div>
            <?php endif; ?>
        </div>

        <div class="card">
            <h2>User Management</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Profile</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo (int) $user['id']; ?></td>
                            <td>
                                <?php if (!empty($user['profile_picture'])): ?>
                                    <img class="avatar" src="/<?php echo htmlspecialchars($user['profile_picture'], ENT_QUOTES, 'UTF-8'); ?>" alt="Profile picture">
                                <?php else: ?>
                                    No image
                                <?php endif; ?>
                            </td>
                            <td><?php echo htmlspecialchars($user['full_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars((string) $user['phone'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($user['role_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td>
                                <?php if (($_SESSION['role_name'] ?? '') === 'Admin'): ?>
                                    <div class="actions">
                                        <form method="post" onsubmit="return confirm('Delete this user?');">
                                            <input type="hidden" name="action" value="delete_user">
                                            <input type="hidden" name="id" value="<?php echo (int) $user['id']; ?>">
                                            <button type="submit">Delete</button>
                                        </form>
                                    </div>
                                <?php else: ?>
                                    <span class="small">View only</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</main>
</body>
</html>

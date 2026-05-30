<?php

declare(strict_types=1);

require_once __DIR__ . '/db.php';

function ensureSessionStarted(): void
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
}

function currentUserId(): ?int
{
    ensureSessionStarted();

    return isset($_SESSION['user_id']) ? (int) $_SESSION['user_id'] : null;
}

function requireLogin(): void
{
    if (currentUserId() === null) {
        header('Location: /index.php?view=login');
        exit;
    }
}

function requireAdmin(): void
{
    requireLogin();

    if (($_SESSION['role_name'] ?? '') !== 'Admin') {
        http_response_code(403);
        exit('Access denied. Admins only.');
    }
}

function loginUser(array $userRow): void
{
    ensureSessionStarted();

    $_SESSION['user_id'] = (int) $userRow['id'];
    $_SESSION['role_id'] = (int) $userRow['role_id'];
    $_SESSION['full_name'] = $userRow['full_name'];
    $_SESSION['email'] = $userRow['email'];
    $_SESSION['role_name'] = $userRow['role_name'];
}

function logoutUser(): void
{
    ensureSessionStarted();
    $_SESSION = [];

    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
    }

    session_destroy();
}

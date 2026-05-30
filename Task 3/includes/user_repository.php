<?php

declare(strict_types=1);

require_once __DIR__ . '/db.php';

function fetchRoles(): array
{
    $result = db()->query('SELECT id, name FROM roles ORDER BY id ASC');

    return $result->fetch_all(MYSQLI_ASSOC);
}

function fetchUsers(): array
{
    $sql = 'SELECT u.id, u.full_name, u.email, u.phone, u.profile_picture, u.created_at, u.updated_at, r.name AS role_name
            FROM users u
            INNER JOIN roles r ON r.id = u.role_id
            ORDER BY u.id DESC';

    $result = db()->query($sql);

    return $result->fetch_all(MYSQLI_ASSOC);
}

function fetchUserById(int $id): ?array
{
    $sql = 'SELECT u.id, u.role_id, u.full_name, u.email, u.phone, u.profile_picture, u.password_hash, r.name AS role_name
            FROM users u
            INNER JOIN roles r ON r.id = u.role_id
            WHERE u.id = ?';

    $stmt = db()->prepare($sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();

    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    return $row ?: null;
}

function fetchUserByEmail(string $email): ?array
{
    $sql = 'SELECT u.id, u.role_id, u.full_name, u.email, u.phone, u.profile_picture, u.password_hash, r.name AS role_name
            FROM users u
            INNER JOIN roles r ON r.id = u.role_id
            WHERE u.email = ?';

    $stmt = db()->prepare($sql);
    $stmt->bind_param('s', $email);
    $stmt->execute();

    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    return $row ?: null;
}

function createUser(array $data): int
{
    $sql = 'INSERT INTO users (role_id, full_name, email, password_hash, phone, profile_picture) VALUES (?, ?, ?, ?, ?, ?)';
    $stmt = db()->prepare($sql);

    $stmt->bind_param(
        'isssss',
        $data['role_id'],
        $data['full_name'],
        $data['email'],
        $data['password_hash'],
        $data['phone'],
        $data['profile_picture']
    );
    $stmt->execute();

    return db()->insert_id;
}

function updateUser(int $id, array $data): void
{
    $sql = 'UPDATE users SET role_id = ?, full_name = ?, email = ?, phone = ?, profile_picture = COALESCE(?, profile_picture) WHERE id = ?';
    $stmt = db()->prepare($sql);
    $stmt->bind_param(
        'issssi',
        $data['role_id'],
        $data['full_name'],
        $data['email'],
        $data['phone'],
        $data['profile_picture'],
        $id
    );
    $stmt->execute();
}

function updatePassword(int $id, string $passwordHash): void
{
    $stmt = db()->prepare('UPDATE users SET password_hash = ? WHERE id = ?');
    $stmt->bind_param('si', $passwordHash, $id);
    $stmt->execute();
}

function deleteUser(int $id): void
{
    $stmt = db()->prepare('DELETE FROM users WHERE id = ?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
}

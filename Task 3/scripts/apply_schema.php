<?php

declare(strict_types=1);

$host = '127.0.0.1';
$user = 'root';
$pass = '';

$schemaPath = __DIR__ . '/../database/schema.sql';
if (!is_readable($schemaPath)) {
    fwrite(STDERR, "Cannot read schema file: $schemaPath\n");
    exit(1);
}

$schema = file_get_contents($schemaPath);
if ($schema === false) {
    fwrite(STDERR, "Failed to load schema.sql\n");
    exit(1);
}

$mysqli = new mysqli($host, $user, $pass);
if ($mysqli->connect_errno) {
    fwrite(STDERR, "MySQL connection failed: " . $mysqli->connect_error . "\n");
    exit(1);
}
$mysqli->set_charset('utf8mb4');

if ($mysqli->multi_query($schema)) {
    do {
        if ($result = $mysqli->store_result()) {
            $result->free();
        }
    } while ($mysqli->more_results() && $mysqli->next_result());

    echo "Schema applied successfully.\n";
    exit(0);
} else {
    fwrite(STDERR, "Error applying schema: " . $mysqli->error . "\n");
    exit(1);
}

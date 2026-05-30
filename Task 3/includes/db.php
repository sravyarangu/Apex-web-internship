<?php

declare(strict_types=1);

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

function db(): mysqli
{
    static $connection = null;

    if ($connection instanceof mysqli) {
        return $connection;
    }

    $host = '127.0.0.1';
    $username = 'root';
    $password = 'dbms';
    $database = 'apex_task3';

    $connection = new mysqli($host, $username, $password, $database);
    $connection->set_charset('utf8mb4');

    return $connection;
}

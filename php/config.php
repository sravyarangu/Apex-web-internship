<?php


define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') ?: '');
define('DB_NAME', getenv('DB_NAME') ?: 'portfolio_db');

define('DB_CHARSET', 'utf8mb4');


function getDBConnection() {
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    if (!$conn) {
        error_log('Database Connection Error: ' . mysqli_connect_error());
        return false;
    }
    
    mysqli_set_charset($conn, DB_CHARSET);
    
    return $conn;
}


function sanitizeInput($input, $conn) {
    return htmlspecialchars($conn->real_escape_string($input), ENT_QUOTES, 'UTF-8');
}

function tableExists($tableName, $conn) {
    $result = $conn->query("SHOW TABLES LIKE '$tableName'");
    return $result && $result->num_rows > 0;
}

function logDBError($message, $function = '') {
    $timestamp = date('Y-m-d H:i:s');
    $logMessage = "[$timestamp] DB Error in $function: $message";
    error_log($logMessage);
}


function setAPIHeaders() {
    header('Content-Type: application/json; charset=utf-8');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Access-Control-Allow-Headers: Content-Type');
}

?>

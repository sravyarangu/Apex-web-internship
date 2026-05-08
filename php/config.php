<?php
/**
 * Database Configuration File
 * Centralized database connection management
 * Used for all database operations in the portfolio website
 */

// ========================================
// DATABASE CONNECTION SETTINGS
// ========================================

// XAMPP Default Configuration (with fallback for other environments)
define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') ?: '');
define('DB_NAME', getenv('DB_NAME') ?: 'portfolio_db');

// Database charset
define('DB_CHARSET', 'utf8mb4');

// ========================================
// CREATE DATABASE CONNECTION
// ========================================

/**
 * Get database connection
 * @return mysqli|false Connection object or false on failure
 */
function getDBConnection() {
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    if (!$conn) {
        error_log('Database Connection Error: ' . mysqli_connect_error());
        return false;
    }
    
    // Set charset to UTF-8
    mysqli_set_charset($conn, DB_CHARSET);
    
    return $conn;
}

// ========================================
// HELPER FUNCTIONS
// ========================================

/**
 * Sanitize string input to prevent SQL injection
 * @param string $input The input string to sanitize
 * @param mysqli $conn Database connection
 * @return string Sanitized string
 */
function sanitizeInput($input, $conn) {
    return htmlspecialchars($conn->real_escape_string($input), ENT_QUOTES, 'UTF-8');
}

/**
 * Check if table exists
 * @param string $tableName Name of the table
 * @param mysqli $conn Database connection
 * @return bool True if table exists, false otherwise
 */
function tableExists($tableName, $conn) {
    $result = $conn->query("SHOW TABLES LIKE '$tableName'");
    return $result && $result->num_rows > 0;
}

/**
 * Log database errors
 * @param string $message Error message
 * @param string $function Function name where error occurred
 */
function logDBError($message, $function = '') {
    $timestamp = date('Y-m-d H:i:s');
    $logMessage = "[$timestamp] DB Error in $function: $message";
    error_log($logMessage);
}

// ========================================
// RESPONSE HEADERS FOR API CALLS
// ========================================

function setAPIHeaders() {
    header('Content-Type: application/json; charset=utf-8');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Access-Control-Allow-Headers: Content-Type');
}

?>

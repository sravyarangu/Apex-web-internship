<?php

// ========================================
// DATABASE CONFIGURATION
// ========================================

$dbhost = 'localhost'; // XAMPP default host
$dbuser = 'root'; // XAMPP default user
$dbpass = ''; // XAMPP default (empty password)
$dbname = 'portfolio_db'; // Database name


header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// ========================================
// CHECK REQUEST METHOD

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method. POST required.'
    ]);
    exit;
}


// Get form inputs
$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$subject = isset($_POST['subject']) ? trim($_POST['subject']) : '';
$message = isset($_POST['message']) ? trim($_POST['message']) : '';

if (empty($name) || strlen($name) < 2) {
    echo json_encode([
        'success' => false,
        'message' => 'Name is required and must be at least 2 characters.'
    ]);
    exit;
}

if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode([
        'success' => false,
        'message' => 'Valid email address is required.'
    ]);
    exit;
}

if (empty($subject) || strlen($subject) < 5) {
    echo json_encode([
        'success' => false,
        'message' => 'Subject is required and must be at least 5 characters.'
    ]);
    exit;
}

if (empty($message) || strlen($message) < 10) {
    echo json_encode([
        'success' => false,
        'message' => 'Message is required and must be at least 10 characters.'
    ]);
    exit;
}


$name = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
$email = filter_var($email, FILTER_SANITIZE_EMAIL);
$subject = htmlspecialchars($subject, ENT_QUOTES, 'UTF-8');
$message = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');


$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

// Check connection
if (!$conn) {
    echo json_encode([
        'success' => false,
        'message' => 'Database connection failed. Please try again later.'
    ]);
    error_log('DB Connection Error: ' . mysqli_connect_error());
    exit;
}

mysqli_set_charset($conn, 'utf8mb4');


$created_at = date('Y-m-d H:i:s');

// Prepare SQL query
$sql = "INSERT INTO contact_messages (name, email, subject, message, created_at) 
        VALUES (?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo json_encode([
        'success' => false,
        'message' => 'Database error. Please try again later.'
    ]);
    error_log('Prepare Error: ' . $conn->error);
    $conn->close();
    exit;
}

// Bind parameters
$stmt->bind_param('sssss', $name, $email, $subject, $message, $created_at);

// Execute query
if ($stmt->execute()) {
    // Success response
    echo json_encode([
        'success' => true,
        'message' => 'Message sent successfully!',
        'message_id' => $stmt->insert_id
    ]);

    // Optional: Send notification email
    $to = 'your-email@example.com'; // Change this to your email
    $email_subject = 'New Portfolio Contact: ' . $subject;
    $email_body = "Name: $name\nEmail: $email\nSubject: $subject\n\nMessage:\n$message";
    $headers = "From: " . $email;

    // Uncomment to enable email notifications
    // mail($to, $email_subject, $email_body, $headers);

} else {
    // Error response
    echo json_encode([
        'success' => false,
        'message' => 'Error saving message. Please try again.'
    ]);
    error_log('Execute Error: ' . $stmt->error);
}


$stmt->close();
$conn->close();

?>

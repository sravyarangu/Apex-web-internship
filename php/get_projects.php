<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'portfolio_db';

$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

if (!$conn) {
    echo json_encode([
        'status' => 'demo',
        'message' => 'Database not configured. Returning demo data.',
        'projects' => [
            [
                'id' => 1,
                'title' => 'Personal Portfolio Website',
                'description' => 'Fully responsive portfolio built with HTML5, CSS3, JavaScript, PHP, and MySQL. Features dynamic content management, contact forms with database integration, and mobile-first responsive design.',
                'technologies' => 'HTML5, CSS3, JavaScript, PHP, MySQL',
                'project_url' => '#',
                'github_url' => '#'
            ],
            [
                'id' => 2,
                'title' => 'E-Commerce Product Catalog',
                'description' => 'Dynamic product listing system powered by MySQL database. Includes search functionality, filtering by category, and responsive grid layout.',
                'technologies' => 'HTML5, CSS3, PHP, MySQL',
                'project_url' => '#',
                'github_url' => '#'
            ],
            [
                'id' => 3,
                'title' => 'Interactive JavaScript Games',
                'description' => 'Collection of fun, interactive games demonstrating vanilla JavaScript capabilities. Includes DOM manipulation, event handling, and responsive animations.',
                'technologies' => 'HTML5, CSS3, JavaScript',
                'project_url' => '#',
                'github_url' => '#'
            ]
        ]
    ]);
    exit;
}

mysqli_set_charset($conn, 'utf8mb4');

$tableCheck = $conn->query("SHOW TABLES LIKE 'projects'");

if (!$tableCheck || $tableCheck->num_rows === 0) {
    echo json_encode([
        'status' => 'demo',
        'message' => 'Projects table not found. Returning demo data.',
        'projects' => [
            [
                'id' => 1,
                'title' => 'Personal Portfolio Website',
                'description' => 'Fully responsive portfolio built with HTML5, CSS3, JavaScript, PHP, and MySQL.',
                'technologies' => 'HTML5, CSS3, JavaScript, PHP, MySQL',
                'project_url' => '#',
                'github_url' => '#'
            ]
        ]
    ]);
    $conn->close();
    exit;
}

$sql = "SELECT id, title, description, technologies, project_url, github_url, image_url, created_at 
        FROM projects 
        WHERE is_active = TRUE 
        ORDER BY created_at DESC";

$result = $conn->query($sql);

if (!$result) {
    echo json_encode([
        'success' => false,
        'message' => 'Error retrieving projects: ' . $conn->error
    ]);
    $conn->close();
    exit;
}

$projects = [];
while ($row = $result->fetch_assoc()) {
    $projects[] = $row;
}

echo json_encode([
    'success' => true,
    'count' => count($projects),
    'projects' => $projects
]);

$conn->close();

?>

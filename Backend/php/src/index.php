<?php
// Enable CORS for the API
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Content-Type: application/json; charset=UTF-8");

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Database connection information
$host = getenv('DB_HOST');
$port = getenv('DB_PORT');
$dbname = getenv('DB_NAME');
$user = getenv('DB_USER');
$password = getenv('DB_PASSWORD');

// Database connection
try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;";
    $conn = new PDO($dsn, $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database connection failed: ' . $e->getMessage()]);
    exit;
}

// Initialize bookmarks table if it doesn't exist
try {
    $conn->exec("
        CREATE TABLE IF NOT EXISTS bookmarks (
            id SERIAL PRIMARY KEY,
            url VARCHAR(500) NOT NULL,
            title VARCHAR(200) NOT NULL, 
            description VARCHAR(1000),
            dateAdded TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ");
    
    // Add some sample data if table is empty
    $stmt = $conn->query("SELECT COUNT(*) as count FROM bookmarks");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($result['count'] == 0) {
        $conn->exec("
            INSERT INTO bookmarks (url, title, description) VALUES 
            ('https://react.dev', 'React Documentation', 'Official React documentation'),
            ('https://developer.mozilla.org', 'MDN Web Docs', 'Resources for web developers')
        ");
    }
} catch (PDOException $e) {
    // Just continue if there's an error here
}

// API routing
$request_uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];
$path = parse_url($request_uri, PHP_URL_PATH);
$segments = explode('/', trim($path, '/'));
$resource = $segments[0] ?? '';
$id = $segments[1] ?? null;
?>

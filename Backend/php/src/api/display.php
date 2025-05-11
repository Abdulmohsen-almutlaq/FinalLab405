<?php

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(array('error' => 'Method not allowed'));
    exit;
}

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');

include_once '../db/db.php';
include_once '../models/bookmark.php';

$database = new Database();
$conn = $database->connect();

// Instantiate bookmark object
$bookmark = new Bookmark($conn);


$result = $bookmark->getAllBookmarks();

if (!empty($result)) {
    http_response_code(200);
    echo json_encode($result); 
} else {

    http_response_code(404); 
    echo json_encode(
        array('message' => '404')
    );
}
?>
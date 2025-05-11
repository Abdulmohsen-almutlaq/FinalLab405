<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');


if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    http_response_code(405);
    echo json_encode(array('error' => 'Method not allowed'));
    exit;
}


header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: DELETE, OPTIONS');
header('Content-Type: application/json');

include_once '../db/db.php';
include_once '../models/bookmark.php';

// Instantiate DB & connect
$database = new Database();
$conn = $database->connect();

$bookmark = new Bookmark($conn);

// Get raw posted data from the request body
$input = json_decode(file_get_contents("php://input"), true);

// Check if ID is provided
if (!$input || !isset($input['id'])) {
    http_response_code(422); 
    echo json_encode(array('error' => 'Invalid input. Please provide a bookmark ID.'));
    exit;
}

$bookmark->setId($input['id']);

// Delete bookmark
if ($bookmark->deleteBookmark()) {
    http_response_code(200);
    echo json_encode(array('msg' => 'Bookmark deleted successfully'));
} else {
    http_response_code(500); // Internal Server Error
    echo json_encode(array('msg' => 'Bookmark not deleted'));
}

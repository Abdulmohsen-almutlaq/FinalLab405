<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');


if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
    http_response_code(405);
    echo json_encode(array('error' => 'Method not allowed. Please use PUT.'));
    exit;
}

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: PUT, OPTIONS');
header('Content-Type: application/json');

include_once '../db/db.php';
include_once '../models/bookmark.php';

// Instantiate DB & connect
$database = new Database();
$conn = $database->connect();

// Instantiate bookmark object
$bookmark = new Bookmark($conn);

// Get raw posted data
$input = json_decode(file_get_contents("php://input"), true);

// Validate input
if (!$input || !isset($input['id']) || !isset($input['url']) || !isset($input['title'])) {
    http_response_code(422); // Unprocessable Entity
    echo json_encode(array('error' => 'Invalid input. Please provide id, url, and title.'));
    exit;
}

$bookmark->setId($input['id']);
$bookmark->setUrl($input['url']);
$bookmark->setTitle($input['title']);

if ($bookmark->updateBookmark()) {
    http_response_code(200);
    echo json_encode(array(
        "msg" => "Bookmark updated successfully",
        "id" => $bookmark->getId(),
        "url" => $bookmark->getUrl(),
        "title" => $bookmark->getTitle()
    ));
} else {
    http_response_code(500); // Internal Server Error
    echo json_encode(array('msg' => 'Bookmark not updated. Ensure the bookmark ID exists.'));
}
?>

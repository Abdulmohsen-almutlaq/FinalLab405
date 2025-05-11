<?php 



if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(array('error' => 'Method not allowed'));
    exit;
}

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('access-Control-Allow-Headers: application/json');
include_once '../db/db.php';
include_once '../models/bookmark.php';

// database OBJ

$database = new Database();
$conn = $database->connect();
$bookmark = new Bookmark($conn);
//Get the Http post req json body
$input = json_decode(file_get_contents('php://input'), true);

if (!$input || !isset($input['url']) || !isset($input['title'])) {
    http_response_code(422);
    echo json_encode('Invalid input');
    exit;
}
// set the bookmark 
$bookmark->setUrl($input['url']);
$bookmark->setTitle($input['title']);
$bookmark->setDateAdded(date('Y-m-d H:i:s'));
// create the bookmark
if ($bookmark->createBookmark()){
    echo json_encode(array("msg" => "bookmark created successfully", "id" => $bookmark->getid(), "url" => $bookmark->getUrl(), "title" => $bookmark->getTitle(), "dateAdded" => $bookmark->getDateAdded() ));
} else {
    echo json_encode(array("msg" => "bookmark not created", "id" => $bookmark->getid(), "url" => $bookmark->getUrl(), "title" => $bookmark->getTitle(), "dateAdded" => $bookmark->getDateAdded() ));
}
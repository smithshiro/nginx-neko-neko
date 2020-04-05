<?php
require_once(dirname(__FILE__)."/../modules/model/posts.php");
const ERR1 = "必須入力項目です";
$errors = [];
foreach ($_POST as $field => $data) {
    if (trim($data) === '') {
        $errors[$field] = ERR1;
    }
}
if (count($errors) > 0) {
    echo json_encode(["code" => 422, "data" => $errors]);
    exit;
}
$name = $_POST["name"];
$comment = $_POST["comment"];

$postsModel = new posts();
$postsModel->createPosts($name, $comment);

echo json_encode(["code" => 200, "data" => []]);
exit;

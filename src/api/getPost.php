<?php
require(dirname(__FILE__)."/../modules/model/posts.php");
$postsModel = new posts();
$result = $postsModel->getPosts();

echo json_encode($result);

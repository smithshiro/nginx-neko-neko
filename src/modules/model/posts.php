<?php
require_once(dirname(__FILE__)."/abstractModel.php");

class posts extends abstractModel
{
    const TABLE = "posts";

    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function getPosts()
    {
        $columns = [
            "id",
            "name",
            "comment",
            "created_at"
        ];
        $params = [];
        return $this->select($columns, $params);
    }

    public function createPosts($name, $comment)
    {
        $data = [
            "name" => $name,
            "comment" => $comment
        ];
        $this->insert($data);
    }
}

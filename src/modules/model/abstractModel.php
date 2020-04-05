<?php

abstract class abstractModel
{
    const DB_PATH = "/../../sqlite/database.sqlite3";
    private $db = null;
    private $table = null;
    private $query = null;

    public function __construct($table)
    {
        try {
            $this->db = new SQLite3(dirname(__FILE__).self::DB_PATH);
            $this->table = $table;
        } catch (\Exception $e) {
            var_dump($e->getMessage());
        }
    }

    protected function insert($params)
    {
        if (!isset($params["id"])) {
            unset($params["id"]);
        }
        $columns_string = implode(array_keys($params), ",");
        $sql = "INSERT INTO {$this->table} ({$columns_string}) VALUES ";
        $prepare_string = "";
        $prepare_values = [];
        foreach ($params as $column => $data) {
            if (strlen($prepare_string) > 0) {
                $prepare_string .= ",";
            }
            $data = SQLite3::escapeString($data);
            $data = htmlentities($data, ENT_QUOTES, "UTF-8");
            $prepare_string .= ":{$column}";
            $prepare_values[":{$column}"] = $data;
        }
        $prepare_string = "(" . $prepare_string . ")";
        $sql .= $prepare_string . ";";
        $stmt = $this->db->prepare($sql);
        foreach ($prepare_values as $prepare => $value) {
            $stmt->bindValue($prepare, $value);
        }
        $stmt->execute();
    }

    protected function select($columns, $params)
    {
        $columns_string = implode($columns, ",");
        $where_params = "";
        foreach ($params as $param => $data) {
            if (strlen($where_params) > 0) {
                $where_params .= " AND ";
            }
            if (gettype($data) === "array") {
                $data_string = implode($data, ",");
                $data_string = sqlite_escape_string($data_string);
                $data_string = htmlentities($data_string, ENT_QUOTES, "UTF-8");
                $where_params .= "{$param} in {$data_string}";
            } else {
                $data = sqlite_escape_string($data);
                $data = htmlentities($data, ENT_QUOTES, "UTF-8");
                $where_params .= "{$param} = {$data}";
            }
        }
        $sql = "SELECT {$columns_string} 
            FROM {$this->table}
        ";
        if (strlen($where_params) > 0) {
            $sql .= " WHERE {$where_params}";
        }
        $sql .= ";";
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute();
        $rows = [];
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $rows[] = $row;
        }
        return $rows;
    }
}

<?php
$db = new SQLite3("../sqlite/database.sqlite3");

$sql = "CREATE TABLE IF NOT EXISTS posts(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT,
    comment TEXT,
    created_at TEXT NOT NULL DEFAULT (DATETIME('now', 'localtime'))
)";
$res = $db->exec($sql);

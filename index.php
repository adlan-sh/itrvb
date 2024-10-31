<?php

require './vendor/autoload.php';

$db = new SQLite3('my_database.db');

$db->exec("CREATE TABLE IF NOT EXISTS users (
    uuid TEXT PRIMARY KEY,
    firstName TEXT NOT NULL,
    lastName TEXT NOT NULL
);");

$db->exec("CREATE TABLE IF NOT EXISTS posts (
    uuid TEXT PRIMARY KEY,
    authorUuid TEXT NOT NULL,
    title TEXT NOT NULL,
    'text' TEXT NOT NULL,
    FOREIGN KEY (authorUuid) REFERENCES users(uuid)
);");

$db->exec("CREATE TABLE IF NOT EXISTS comments (
    uuid TEXT PRIMARY KEY,
    authorUuid TEXT NOT NULL,
    postUuid TEXT NOT NULL,
    'text' TEXT NOT NULL,
    FOREIGN KEY (authorUuid) REFERENCES users(uuid),
    FOREIGN KEY (postUuid) REFERENCES posts(uuid)
);");


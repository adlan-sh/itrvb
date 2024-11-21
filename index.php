<?php

require_once './vendor/autoload.php';

$db = new PDO('sqlite:' . __DIR__ . '/my_database.sqlite');

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

use Itrvb\Lab4\Commands\CreateCommentCommand;
use Itrvb\Lab4\Commands\CreatePostCommand;
use Itrvb\Lab4\Queries\GetCommentQuery;
use Itrvb\Lab4\Queries\GetPostQuery;
use Itrvb\Lab4\Repository\PostsRepository;
use Itrvb\Lab4\Repository\CommentsRepository;

$postsRepository = new PostsRepository($db);
$commentsRepository = new CommentsRepository($db);

$postCommand = new CreatePostCommand($postsRepository);
$commentCommand = new CreateCommentCommand($commentsRepository);

$postCommand->handle($argv);      // создание поста
//$commentCommand->handle($argv); // создание комментария

$postQuery = new GetPostQuery($postsRepository);
$commentQuery = new GetCommentQuery($commentsRepository);

//var_dump($postQuery->handle($argv));      // получение поста
//var_dump($commentQuery->handle($argv));   // получение комментария

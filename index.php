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

$db->exec("CREATE TABLE IF NOT EXISTS likes (
    uuid TEXT PRIMARY KEY,
    postUuid TEXT NOT NULL,
    userUuid TEXT NOT NULL
);");

use Itrvb\Lab4\Commands\Comment\CreateCommentCommand;
use Itrvb\Lab4\Commands\Post\CreatePostCommand;
use Itrvb\Lab4\Queries\Comment\GetCommentQuery;
use Itrvb\Lab4\Queries\Post\GetPostQuery;
use Itrvb\Lab4\Repository\CommentsRepository;
use Itrvb\Lab4\Repository\PostsRepository;

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

<?php

require './vendor/autoload.php';

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

use Itrvb\Lab4\Repository\PostsRepository;
use Itrvb\Lab4\Repository\CommentsRepository;
use Itrvb\Lab4\Model\Post;
use Itrvb\Lab4\Model\Comment;

$faker = Faker\Factory::create();

$postsRepository = new PostsRepository($db);
$commentsRepository = new CommentsRepository($db);

$postUuid = $faker->uuid();
$authorUuid = $faker->uuid();
$commentUuid = $faker->uuid();

$post = new Post();
$post->uuid = $postUuid;
$post->authorUuid = $authorUuid;
$post->title = 'Заголовок поста';
$post->text = 'Текст поста';

$postsRepository->save($post);
$postDb = $postsRepository->get($postUuid);
var_dump($postDb);


$comment = new Comment();
$comment->uuid = $commentUuid;
$comment->authorUuid = $authorUuid;
$comment->postUuid = $postUuid;
$comment->text = 'Текст комментария';

$commentsRepository->save($comment);
$commentDb = $commentsRepository->get($commentUuid);
var_dump($commentDb);

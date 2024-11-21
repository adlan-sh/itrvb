<?php

require_once './vendor/autoload.php';

use Itrvb\Lab4\Commands\CreateCommentCommand;
use Itrvb\Lab4\Commands\CreatePostCommand;
use Itrvb\Lab4\Commands\DeletePostCommand;
use Itrvb\Lab4\Http\Actions\Comment\CreateComment;
use Itrvb\Lab4\Http\Actions\Post\CreatePost;
use Itrvb\Lab4\Http\Actions\Post\DeletePost;
use Itrvb\Lab4\Http\ErrorResponse;
use Itrvb\Lab4\Http\Request;
use Itrvb\Lab4\Repository\CommentsRepository;
use Itrvb\Lab4\Repository\PostsRepository;
use Itrvb\Lab4\Exception\HttpException;
use Itrvb\Lab4\Repository\UsersRepository;

$db = new PDO('sqlite:' . __DIR__ . '/my_database.sqlite');
$postsRepository = new PostsRepository($db);
$commentsRepository = new CommentsRepository($db);
$userRepository = new UsersRepository($db);

$postCommand = new CreatePostCommand($postsRepository);
$postDeleteCommand = new DeletePostCommand($postsRepository);
$commentCommand = new CreateCommentCommand($commentsRepository);

$content = json_decode(
    file_get_contents('php://input'),
    true
);
$request = new Request(
    $_GET,
    $content ?? [],
    $_SERVER
);

try {
    $path = $request->path();
} catch (HttpException) {
    (new ErrorResponse())->send();
    return;
}

$routes = [
    '/posts/comment' => new CreateComment($commentCommand),
    '/posts' => new CreatePost($postCommand, $userRepository),
    '/posts/delete' => new DeletePost($postDeleteCommand),
];

if (!array_key_exists($path, $routes)) {
    (new ErrorResponse('Route not found'))->send();
    return;
}

$action = $routes[$path];

try {
    $response = $action->handle($request);
    $response->send();
    die();
} catch (Exception $e) {
    (new ErrorResponse($e->getMessage()))->send();
}

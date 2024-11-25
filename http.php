<?php

require_once './vendor/autoload.php';

use Itrvb\Lab4\Commands\Comment\CreateCommentCommand;
use Itrvb\Lab4\Commands\Like\CreateLikeCommand;
use Itrvb\Lab4\Commands\Post\CreatePostCommand;
use Itrvb\Lab4\Commands\Post\DeletePostCommand;
use Itrvb\Lab4\Exception\HttpException;
use Itrvb\Lab4\Http\Actions\Comment\CreateComment;
use Itrvb\Lab4\Http\Actions\Like\CreateLike;
use Itrvb\Lab4\Http\Actions\Like\GetLikes;
use Itrvb\Lab4\Http\Actions\Post\CreatePost;
use Itrvb\Lab4\Http\Actions\Post\DeletePost;
use Itrvb\Lab4\Http\ErrorResponse;
use Itrvb\Lab4\Http\Request;
use Itrvb\Lab4\Queries\Like\GetLikesQuery;
use Itrvb\Lab4\Repository\CommentsRepository;
use Itrvb\Lab4\Repository\LikesRepository;
use Itrvb\Lab4\Repository\PostsRepository;
use Itrvb\Lab4\Repository\UsersRepository;
use Monolog\Handler\StreamHandler;

$db = new PDO('sqlite:' . __DIR__ . '/my_database.sqlite');
$logger = new Monolog\Logger('my_logger', [new StreamHandler('./logs/app.log')]);

$postsRepository = new PostsRepository($db, $logger);
$commentsRepository = new CommentsRepository($db, $logger);
$userRepository = new UsersRepository($db, $logger);
$likesRepository = new LikesRepository($db, $logger);

$postCommand = new CreatePostCommand($postsRepository);
$postDeleteCommand = new DeletePostCommand($postsRepository);
$commentCommand = new CreateCommentCommand($commentsRepository);
$likeCommand = new CreateLikeCommand($likesRepository);

$likeQuery = new GetLikesQuery($likesRepository);

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
    '/posts/like' => new CreateLike($likeCommand),
    '/posts/likes' => new GetLikes($likeQuery)
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

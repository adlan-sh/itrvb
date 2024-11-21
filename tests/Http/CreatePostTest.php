<?php

namespace Http;

use Itrvb\Lab4\Commands\CreatePostCommand;
use Itrvb\Lab4\Exception\InvalidUuidException;
use Itrvb\Lab4\Exception\UserNotFoundException;
use Itrvb\Lab4\Http\Actions\Post\CreatePost;
use Itrvb\Lab4\Http\Request;
use Itrvb\Lab4\Model\User;
use Itrvb\Lab4\Repository\Interfaces\PostsRepositoryInterface;
use Itrvb\Lab4\Repository\Interfaces\UsersRepositoryInterface;
use Itrvb\Lab4\Repository\PostsRepository;
use Itrvb\Lab4\Repository\UsersRepository;
use PDO;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

class CreatePostTest extends TestCase
{
    private static Uuid $authorUuid;

    private static UsersRepositoryInterface $usersRepository;

    private static PostsRepositoryInterface $postsRepository;

    protected function setUp(): void
    {
        self::$authorUuid = Uuid::v4();
        $pdo = new PDO('sqlite:' . './../../my_database.sqlite');
        self::$postsRepository = new PostsRepository($pdo);
        self::$usersRepository = new UsersRepository($pdo);
        self::$usersRepository->save(
            new User(self::$authorUuid, 'test name', 'test surname')
        );
    }

    public function test_createPostSuccess(): void
    {
        $request = new Request([], [
            'author_uuid' => self::$authorUuid->toString(),
            'title' => 'test title',
            'text' => 'test text',
        ], []);
        $command = new CreatePostCommand(self::$postsRepository);

        $action = new CreatePost($command, self::$usersRepository);

        $response = $action->handle($request);

        $this->expectOutputString('{"success":true,"data":{"message":"Post was created successfully","title":"test title","text":"test text"}}');

        $response->send();
    }

    public function test_createPostInvalidUUID(): void
    {
        $request = new Request([], [
            'author_uuid' => '123',
            'title' => 'test title',
            'text' => 'test text',
        ], []);
        $command = new CreatePostCommand(self::$postsRepository);

        $action = new CreatePost($command, self::$usersRepository);

        $this->expectException(InvalidUuidException::class);

        $response = $action->handle($request);

        $response->send();
    }

    public function test_createPostWithUserNotFound(): void
    {
        $request = new Request([], [
            'author_uuid' => Uuid::v4()->toString(),
            'title' => 'test title',
            'text' => 'test text',
        ], []);
        $command = new CreatePostCommand(self::$postsRepository);

        $action = new CreatePost($command, self::$usersRepository);

        $this->expectException(UserNotFoundException::class);

        $response = $action->handle($request);

        $response->send();
    }

    public function test_createPostWithNoSuchParam(): void
    {
        $request = new Request([], [
            'author_uuid' => self::$authorUuid->toString(),
            'text' => 'test text',
        ], []);
        $command = new CreatePostCommand(self::$postsRepository);

        $action = new CreatePost($command, self::$usersRepository);

        $response = $action->handle($request);

        $this->expectOutputString('{"success":false,"message":"No such body param in the request: title"}');

        $response->send();
    }
}

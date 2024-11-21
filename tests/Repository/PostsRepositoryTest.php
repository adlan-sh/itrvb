<?php

declare(strict_types=1);

use Itrvb\Lab4\Exception\PostNotFoundException;
use Itrvb\Lab4\Model\Post;
use Itrvb\Lab4\Repository\Interfaces\PostsRepositoryInterface;
use Itrvb\Lab4\Repository\PostsRepository;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

class PostsRepositoryTest extends TestCase
{
    private PostsRepositoryInterface $postsRepository;

    private static Uuid $uuid;

    private static Uuid $authorUuid;

    public function setUp(): void
    {
        $pdo = new PDO('sqlite:' . './../../my_database.sqlite');
        $this->postsRepository = new PostsRepository($pdo);
        if (!isset(self::$uuid)) {
            self::$uuid = Uuid::v4();
            self::$authorUuid = Uuid::v4();
        }
    }

    public function test_savePost(): void
    {
        $post = new Post(
            self::$uuid,
            self::$authorUuid,
            'Test title',
            'Test text'
        );
        $this->assertTrue($this->postsRepository->save($post));
    }

    public function test_getPost(): void
    {
        $post = new Post(
            self::$uuid,
            self::$authorUuid,
            'Test title',
            'Test text'
        );

        $postDb = $this->postsRepository->get((string) self::$uuid);
        var_dump($postDb);
        var_dump($post);

        $this->assertEquals($post, $postDb);
    }

    public function test_getPostWithException(): void
    {
        $this->expectException(PostNotFoundException::class);

        $this->postsRepository->get('123');
    }
}
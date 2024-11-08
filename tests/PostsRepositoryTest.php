<?php

use Itrvb\Lab4\Exception\PostNotFoundException;
use Itrvb\Lab4\Model\Post;
use Itrvb\Lab4\Repository\PostsRepository;
use PHPUnit\Framework\TestCase;
use Itrvb\Lab4\Repository\PostsRepositoryInterface;

class PostsRepositoryTest extends TestCase
{
    private PostsRepositoryInterface $postsRepository;

    private static string $uuid;

    private static string $authorUuid;

    public function setUp(): void
    {
        $pdo = new PDO('sqlite:' . './../my_database.sqlite');
        $this->postsRepository = new PostsRepository($pdo);
        if (!isset(self::$uuid)) {
            $faker = Faker\Factory::create();
            self::$uuid = $faker->uuid();
            self::$authorUuid = $faker->uuid();
        }
    }

    public function test_savePost(): void
    {
        $post = new Post();
        $post->uuid = self::$uuid;
        $post->authorUuid = self::$authorUuid;
        $post->title = 'Test title';
        $post->text = 'Test text';
        $this->expectOutputRegex('/Post was saved/');
        $this->postsRepository->save($post);
    }

    public function test_getPost(): void
    {
        $post = new Post();
        $post->uuid = self::$uuid;
        $post->authorUuid = self::$authorUuid;
        $post->title = 'Test title';
        $post->text = 'Test text';

        $postDb = $this->postsRepository->get(self::$uuid);

        $this->assertEquals($post, $postDb);
    }

    public function test_getPostWithException(): void
    {
        $this->expectException(PostNotFoundException::class);

        $this->postsRepository->get('123');
    }
}

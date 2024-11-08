<?php

use Itrvb\Lab4\Exception\CommentNotFoundException;
use Itrvb\Lab4\Model\Comment;
use Itrvb\Lab4\Repository\CommentsRepository;
use Itrvb\Lab4\Repository\CommentsRepositoryInterface;
use PHPUnit\Framework\TestCase;

class CommentsRepositoryTest extends TestCase
{
    private CommentsRepositoryInterface $commentsRepository;

    private static string $uuid;

    private static string $authorUuid;

    private static string $postUuid;

    public function setUp(): void
    {
        $pdo = new PDO('sqlite:' . './../my_database.sqlite');
        $this->commentsRepository = new CommentsRepository($pdo);
        if (!isset(self::$uuid)) {
            $faker = Faker\Factory::create();
            self::$uuid = $faker->uuid();
            self::$authorUuid = $faker->uuid();
            self::$postUuid = $faker->uuid();
        }
    }

    public function test_saveComment(): void
    {
        $comment = new Comment();
        $comment->uuid = self::$uuid;
        $comment->authorUuid = self::$authorUuid;
        $comment->postUuid = self::$postUuid;
        $comment->text = 'Test text';
        $this->expectOutputRegex('/Comment was saved/');
        $this->commentsRepository->save($comment);
    }

    public function test_getComment(): void
    {
        $comment = new Comment();
        $comment->uuid = self::$uuid;
        $comment->authorUuid = self::$authorUuid;
        $comment->postUuid = self::$postUuid;
        $comment->text = 'Test text';

        $commentDb = $this->commentsRepository->get(self::$uuid);

        $this->assertEquals($comment, $commentDb);
    }

    public function test_getCommentWithException(): void
    {
        $this->expectException(CommentNotFoundException::class);

        $this->commentsRepository->get('123');
    }
}

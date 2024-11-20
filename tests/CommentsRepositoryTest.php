<?php

use Itrvb\Lab4\Exception\CommentNotFoundException;
use Itrvb\Lab4\Model\Comment;
use Itrvb\Lab4\Repository\CommentsRepository;
use Itrvb\Lab4\Repository\Interfaces\CommentsRepositoryInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

class CommentsRepositoryTest extends TestCase
{
    private CommentsRepositoryInterface $commentsRepository;

    private static Uuid $uuid;

    private static Uuid $authorUuid;

    private static Uuid $postUuid;

    public function setUp(): void
    {
        $pdo = new PDO('sqlite:' . './../my_database.sqlite');
        $this->commentsRepository = new CommentsRepository($pdo);
        if (!isset(self::$uuid)) {
            self::$uuid = Uuid::v4();
            self::$authorUuid = Uuid::v4();
            self::$postUuid = Uuid::v4();
        }
    }

    public function test_saveComment(): void
    {
        $comment = new Comment(
            self::$uuid,
            self::$authorUuid,
            self::$postUuid,
            'Test text'
        );
        $this->expectOutputRegex('/Comment was saved/');
        $this->commentsRepository->save($comment);
    }

    public function test_getComment(): void
    {
        $comment = new Comment(
            self::$uuid,
            self::$authorUuid,
            self::$postUuid,
            'Test text'
        );

        $commentDb = $this->commentsRepository->get(self::$uuid);

        $this->assertEquals($comment, $commentDb);
    }

    public function test_getCommentWithException(): void
    {
        $this->expectException(CommentNotFoundException::class);

        $this->commentsRepository->get('123');
    }
}

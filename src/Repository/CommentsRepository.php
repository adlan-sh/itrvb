<?php

declare(strict_types = 1);

namespace Itrvb\Lab4\Repository;

use Itrvb\Lab4\Exception\CommentNotFoundException;
use Itrvb\Lab4\Model\Comment;
use Itrvb\Lab4\Repository\Interfaces\CommentsRepositoryInterface;
use PDO;
use Psr\Log\LoggerInterface;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Uid\UuidV4;

class CommentsRepository implements CommentsRepositoryInterface
{
    public function __construct(private PDO $db, private LoggerInterface $logger)
    {
    }

    public function get(string $uuid): Comment
    {
        $sql = "SELECT * FROM comments WHERE `uuid` = :uuid";
        $prp = $this->db->prepare($sql);

        $prp->execute(['uuid' => $uuid]);
        $result = $prp->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            $this->logger->warning('Comment not found', ['uuid' => $uuid]);
            throw new CommentNotFoundException();
        }

        return new Comment(
            new UuidV4($result['uuid']),
            new UuidV4($result['authorUuid']),
            new UuidV4($result['postUuid']),
            $result['text']
        );
    }

    public function save(Comment $comment): void
    {
        $sql = "INSERT INTO `comments` (`uuid`, `authorUuid`, `postUuid`, `text`) VALUES (:uuid, :authorUuid, :postUuid, :text)";
        $prp = $this->db->prepare($sql);
        $params = [
            'uuid' => $comment->uuid,
            'authorUuid' => $comment->authorUuid,
            'postUuid' => $comment->postUuid,
            'text' => $comment->text
        ];

        if ($prp->execute($params)) {
            $this->logger->info('Comment was created with uuid: ' . $comment->uuid);
        }

        echo "Comment was saved \n";
    }
}

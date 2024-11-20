<?php

declare(strict_types = 1);

namespace Itrvb\Lab4\Repository;

use Itrvb\Lab4\Exception\CommentNotFoundException;
use Itrvb\Lab4\Model\Comment;
use Itrvb\Lab4\Repository\Interfaces\CommentsRepositoryInterface;
use PDO;
use Symfony\Component\Uid\Uuid;

class CommentsRepository implements CommentsRepositoryInterface
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function get(string $uuid): Comment
    {
        $sql = "SELECT * FROM comments WHERE `uuid` = :uuid";
        $prp = $this->db->prepare($sql);

        $prp->execute(['uuid' => $uuid]);
        $result = $prp->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            throw new CommentNotFoundException();
        }

        return new Comment(
            new Uuid($result['uuid']),
            new Uuid($result['authorUuid']),
            new Uuid($result['postUuid']),
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
        $prp->execute($params);

        echo "Comment was saved \n";
    }
}

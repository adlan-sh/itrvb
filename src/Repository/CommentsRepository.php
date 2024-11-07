<?php

namespace Itrvb\Lab4\Repository;

use Itrvb\Lab4\Repository\CommentsRepositoryInterface;
use Itrvb\Lab4\Model\Comment;
use PDO;

class CommentsRepository implements CommentsRepositoryInterface
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function get(string $uuid): Comment
    {
        $sql = "SELECT * FROM comments WHERE `uuid` = '$uuid'";
        $data = $this->db->query($sql)->fetch(PDO::FETCH_ASSOC);
        $comment = new Comment();
        $comment->uuid = $data['uuid'];
        $comment->authorUuid = $data['authorUuid'];
        $comment->text = $data['text'];
        $comment->postUuid = $data['postUuid'];

        return $comment;
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

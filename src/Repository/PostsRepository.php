<?php

declare(strict_types = 1);

namespace Itrvb\Lab4\Repository;

use Itrvb\Lab4\Exception\PostNotFoundException;
use Itrvb\Lab4\Repository\Interfaces\PostsRepositoryInterface;
use Itrvb\Lab4\Model\Post;
use PDO;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Uid\UuidV4;

class PostsRepository implements PostsRepositoryInterface
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function get(string $uuid): Post
    {
        $sql = "SELECT * FROM posts WHERE `uuid` = :uuid";
        $prp = $this->db->prepare($sql);

        $prp->execute(['uuid' => $uuid]);
        $result = $prp->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            throw new PostNotFoundException();
        }

        return new Post(
            new UuidV4($result['uuid']),
            new UuidV4($result['authorUuid']),
            $result['title'],
            $result['text']
        );
    }

    public function save(Post $post): void
    {
        $sql = "INSERT INTO `posts` (`uuid`, `authorUuid`, `title`, `text`) VALUES (:uuid, :authorUuid, :title, :text)";
        $prp = $this->db->prepare($sql);
        $params = [
            'uuid' => $post->uuid,
            'authorUuid' => $post->authorUuid,
            'title' => $post->title,
            'text' => $post->text
        ];
        $prp->execute($params);

        echo "Post was saved \n";
    }
}

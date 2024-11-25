<?php

declare(strict_types = 1);

namespace Itrvb\Lab4\Repository;

use Itrvb\Lab4\Exception\PostNotFoundException;
use Itrvb\Lab4\Repository\Interfaces\PostsRepositoryInterface;
use Itrvb\Lab4\Model\Post;
use PDO;
use Psr\Log\LoggerInterface;
use Symfony\Component\Uid\UuidV4;

class PostsRepository implements PostsRepositoryInterface
{

    public function __construct(private PDO $db, private LoggerInterface $logger)
    {
    }

    public function get(string $uuid): Post
    {
        $sql = "SELECT * FROM posts WHERE `uuid` = :uuid";
        $prp = $this->db->prepare($sql);

        $prp->execute(['uuid' => $uuid]);
        $result = $prp->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            $this->logger->warning('Post not found', ['uuid' => $uuid]);
            throw new PostNotFoundException();
        }

        return new Post(
            new UuidV4($result['uuid']),
            new UuidV4($result['authorUuid']),
            $result['title'],
            $result['text']
        );
    }

    public function save(Post $post): bool
    {
        $sql = "INSERT INTO `posts` (`uuid`, `authorUuid`, `title`, `text`) VALUES (:uuid, :authorUuid, :title, :text)";
        $prp = $this->db->prepare($sql);
        $params = [
            'uuid' => $post->uuid,
            'authorUuid' => $post->authorUuid,
            'title' => $post->title,
            'text' => $post->text
        ];

        if ($prp->execute($params)) {
            $this->logger->info('Post was created with uuid: ' . $post->uuid);
        }

        return true;
    }

    public function delete(string $uuid): bool
    {
        $sql = "DELETE FROM `posts` WHERE uuid = :uuid";
        $prp = $this->db->prepare($sql);
        $params = [
            'uuid' => $uuid,
        ];
        $prp->execute($params);

        return true;
    }
}

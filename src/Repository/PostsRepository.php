<?php

namespace Itrvb\Lab4\Repository;

use Itrvb\Lab4\Exception\PostNotFoundException;
use Itrvb\Lab4\Repository\PostsRepositoryInterface;
use Itrvb\Lab4\Model\Post;
use PDO;

class PostsRepository implements PostsRepositoryInterface
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function get(string $uuid): Post
    {
        $sql = "SELECT * FROM posts WHERE `uuid` = '$uuid'";
        $data = $this->db->query($sql)->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            throw new PostNotFoundException();
        }

        $post = new Post();
        $post->uuid = $data['uuid'];
        $post->title = $data['title'];
        $post->text = $data['text'];
        $post->authorUuid = $data['authorUuid'];

        return $post;
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

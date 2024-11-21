<?php

declare(strict_types = 1);

namespace Itrvb\Lab4\Repository;

use Itrvb\Lab4\Model\Like;
use Itrvb\Lab4\Repository\Interfaces\LikesRepositoryInterface;
use PDO;

class LikesRepository implements LikesRepositoryInterface
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function save(Like $like): void
    {
        $sql = "INSERT INTO `likes` (`uuid`, `postUuid`, `userUuid`) VALUES (:uuid, :postUuid, :userUuid)";
        $prp = $this->db->prepare($sql);
        $params = [
            'uuid' => $like->uuid,
            'postUuid' => $like->postUuid,
            'userUuid' => $like->userUuid
        ];
        $prp->execute($params);
    }

    public function getByPostUuid(string $uuid): array
    {
        $sql = "SELECT * FROM likes WHERE `postUuid` = :postUuid";
        $prp = $this->db->prepare($sql);

        $prp->execute(['postUuid' => $uuid]);
        $result = [];
        while ($row = $prp->fetch(PDO::FETCH_ASSOC)) {
            $result[] = $row;
        }

        return $result;
    }

    public function isExists(string $postUuid, string $userUuid): bool
    {
        $sql = "SELECT * FROM likes WHERE `postUuid` = :postUuid AND `userUuid` = :userUuid";
        $prp = $this->db->prepare($sql);

        $prp->execute(['postUuid' => $postUuid, 'userUuid' => $userUuid]);
        $result = $prp->fetch(PDO::FETCH_ASSOC);

        return !empty($result);
    }
}

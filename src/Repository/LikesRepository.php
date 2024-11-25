<?php

declare(strict_types = 1);

namespace Itrvb\Lab4\Repository;

use Itrvb\Lab4\Model\Like;
use Itrvb\Lab4\Repository\Interfaces\LikesRepositoryInterface;
use PDO;
use Psr\Log\LoggerInterface;

class LikesRepository implements LikesRepositoryInterface
{
    public function __construct(private PDO $db, private LoggerInterface $logger)
    {
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

        if($prp->execute($params)) {
            $this->logger->info('Like was created with uuid: ' . $like->uuid);
        }
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

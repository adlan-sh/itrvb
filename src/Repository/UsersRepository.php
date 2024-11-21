<?php

declare(strict_types = 1);

namespace Itrvb\Lab4\Repository;

use Itrvb\Lab4\Exception\UserNotFoundException;
use Itrvb\Lab4\Model\User;
use Itrvb\Lab4\Repository\Interfaces\UsersRepositoryInterface;
use PDO;
use Symfony\Component\Uid\UuidV4;

class UsersRepository implements UsersRepositoryInterface
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function get(string $uuid): User
    {
        $sql = "SELECT * FROM users WHERE `uuid` = :uuid";
        $prp = $this->db->prepare($sql);

        $prp->execute(['uuid' => $uuid]);
        $result = $prp->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            throw new UserNotFoundException();
        }

        return new User(
            new UuidV4($result['uuid']),
            $result['firstName'],
            $result['lastName']
        );
    }

    public function save(User $user): void
    {
        $sql = "INSERT INTO `users` (`uuid`, `firstName`, `lastName`) VALUES (:uuid, :firstName, :lastName)";
        $prp = $this->db->prepare($sql);
        $params = [
            'uuid' => $user->uuid,
            'firstName' => $user->firstName,
            'lastName' => $user->lastName,
        ];
        $prp->execute($params);
    }
}

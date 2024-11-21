<?php

declare(strict_types = 1);

namespace Itrvb\Lab4\Repository\Interfaces;

use Itrvb\Lab4\Model\Like;

interface LikesRepositoryInterface
{
    public function save(Like $like): void;

    public function getByPostUuid(string $uuid): array;

    public function isExists(string $postUuid, string $userUuid): bool;
}

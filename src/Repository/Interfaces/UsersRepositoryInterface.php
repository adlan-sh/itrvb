<?php

declare(strict_types = 1);

namespace Itrvb\Lab4\Repository\Interfaces;

use Itrvb\Lab4\Model\User;

interface UsersRepositoryInterface
{
    public function get(string $uuid): User;
    public function save(User $user): void;
}
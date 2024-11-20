<?php

declare(strict_types = 1);

namespace Itrvb\Lab4\Repository\Interfaces;

use Faker\Core\Uuid;
use Itrvb\Lab4\Model\Post;

interface PostsRepositoryInterface
{
    public function get(string $uuid): Post;

    public function save(Post $post): void;
}

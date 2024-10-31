<?php

namespace Itrvb\Lab4\Repository;

use Faker\Core\Uuid;
use Itrvb\Lab4\Model\Post;

interface PostsRepositoryInterface
{
    public function get(Uuid $uuid): Post;

    public function save(Post $post): void;
}

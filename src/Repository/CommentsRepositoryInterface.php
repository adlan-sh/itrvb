<?php

namespace Itrvb\Lab4\Repository;

use Faker\Core\Uuid;
use Itrvb\Lab4\Model\Comment;

interface CommentsRepositoryInterface
{
    public function get(Uuid $uuid): Comment;

    public function save(Comment $post): void;
}

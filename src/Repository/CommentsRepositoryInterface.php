<?php

namespace Itrvb\Lab4\Repository;

use Itrvb\Lab4\Model\Comment;

interface CommentsRepositoryInterface
{
    public function get(string $uuid): Comment;

    public function save(Comment $comment): void;
}

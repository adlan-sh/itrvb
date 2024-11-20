<?php

namespace Itrvb\Lab4\Command\Comment;

use Itrvb\Lab4\Model\Comment;
use Itrvb\Lab4\Repository\CommentsRepositoryInterface;

class CreateComment
{
    public function __construct(private CommentsRepositoryInterface $commentsRepository)
    {
    }

    public function execute(array $data): Comment
    {

    }
}

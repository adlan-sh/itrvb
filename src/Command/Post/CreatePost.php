<?php

namespace Itrvb\Lab4\Command\Post;

use Itrvb\Lab4\Model\Post;
use Itrvb\Lab4\Repository\PostsRepositoryInterface;

class CreatePost
{
    public function __construct(private PostsRepositoryInterface $postsRepository)
    {
    }

    public function execute(array $data): Post
    {

    }
}
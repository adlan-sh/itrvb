<?php

declare(strict_types = 1);

namespace Itrvb\Lab4\Model;

use Symfony\Component\Uid\Uuid;

class Comment
{
    public function __construct(
        public Uuid $uuid,

        public Uuid $authorUuid,

        public Uuid $postUuid,

        public string $text,
    ) {
    }
}

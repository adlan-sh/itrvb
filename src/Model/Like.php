<?php

declare(strict_types = 1);

namespace Itrvb\Lab4\Model;

use Symfony\Component\Uid\Uuid;

class Like
{
    public function __construct(
        public Uuid $uuid,

        public Uuid $postUuid,

        public Uuid $userUuid,
    ) {
    }
}

<?php

namespace Itrvb\Lab4\Model;

use Faker\Core\Uuid;

class Comment
{
    public string $uuid;

    public string $authorUuid;

    public string $postUuid;

    public string $text;
}

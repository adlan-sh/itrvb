<?php

namespace Itrvb\Lab4\Model;

use Faker\Core\Uuid;

class Comment
{
    public Uuid $uuid;

    public Uuid $authorUuid;

    public Uuid $postUuid;

    public string $text;
}

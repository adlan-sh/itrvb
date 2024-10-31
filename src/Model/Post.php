<?php

namespace Itrvb\Lab4\Model;

use Faker\Core\Uuid;

class Post
{
    public Uuid $uuid;

    public Uuid $authorUuid;

    public string $title;

    public string $text;
}


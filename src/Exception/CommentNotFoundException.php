<?php

namespace Itrvb\Lab4\Exception;

class CommentNotFoundException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Comment not found');
    }
}

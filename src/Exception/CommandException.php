<?php

declare(strict_types = 1);

namespace Itrvb\Lab4\Exception;

use Exception;

class CommandException extends Exception
{
    public function __construct(string $message, string $argument)
    {
        parent::__construct($message . $argument);
    }
}

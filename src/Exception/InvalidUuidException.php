<?php

namespace Itrvb\Lab4\Exception;

class InvalidUuidException extends \Exception
{
    public function __construct(string $uuid)
    {
        parent::__construct('Invalid UUID: ' . $uuid);
    }
}
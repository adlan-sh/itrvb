<?php

declare(strict_types=1);

namespace Itrvb\Lab4\Http;

class ErrorResponse extends Response
{
    protected const SUCCESS = false;

    public function __construct(
        private string $message = 'Something went wrong',
    ) {
    }

    protected function payload(): array
    {
        return ['message' => $this->message];
    }
}

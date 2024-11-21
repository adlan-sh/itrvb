<?php

declare(strict_types = 1);

namespace Itrvb\Lab4\Http\Actions;

use Itrvb\Lab4\Http\Request;
use Itrvb\Lab4\Http\Response;

interface ActionInterface
{
    public function handle(Request $request): Response;
}

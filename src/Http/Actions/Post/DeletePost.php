<?php

declare(strict_types = 1);

namespace Itrvb\Lab4\Http\Actions\Post;

use Itrvb\Lab4\Commands\DeletePostCommand;
use Itrvb\Lab4\Exception\HttpException;
use Itrvb\Lab4\Http\Actions\ActionInterface;
use Itrvb\Lab4\Http\ErrorResponse;
use Itrvb\Lab4\Http\Request;
use Itrvb\Lab4\Http\Response;
use Itrvb\Lab4\Http\SuccessResponse;

class DeletePost implements ActionInterface
{
    public function __construct(
        private DeletePostCommand $command,
    ) {
    }

    public function handle(Request $request): Response
    {
        try {
            $uuid = $request->query('uuid');

            $this->command->handle([
                'uuid' => $uuid,
            ]);
        } catch (HttpException $ex) {
            return new ErrorResponse($ex->getMessage());
        }

        return new SuccessResponse([
            'message' => 'Post was deleted successfully',
        ]);
    }
}

<?php

declare(strict_types = 1);

namespace Itrvb\Lab4\Http\Actions\Like;

use Itrvb\Lab4\Commands\Like\CreateLikeCommand;
use Itrvb\Lab4\Exception\HttpException;
use Itrvb\Lab4\Http\Actions\ActionInterface;
use Itrvb\Lab4\Http\ErrorResponse;
use Itrvb\Lab4\Http\Request;
use Itrvb\Lab4\Http\Response;
use Itrvb\Lab4\Http\SuccessResponse;

class CreateLike implements ActionInterface
{
    public function __construct(private CreateLikeCommand $command)
    {
    }

    public function handle(Request $request): Response
    {
        try {
            $authorUuid = $request->body('post_uuid');
            $postUuid = $request->body('user_uuid');
            $this->command->handle([
                'postUuid' => $authorUuid,
                'userUuid' => $postUuid,
            ]);
        } catch (HttpException $ex) {
            return new ErrorResponse($ex->getMessage());
        }

        return new SuccessResponse([
            'message' => 'Like was added successfully',
        ]);
    }
}

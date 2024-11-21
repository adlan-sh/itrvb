<?php

declare(strict_types = 1);

namespace Itrvb\Lab4\Http\Actions\Comment;

use Itrvb\Lab4\Commands\Comment\CreateCommentCommand;
use Itrvb\Lab4\Exception\HttpException;
use Itrvb\Lab4\Http\Actions\ActionInterface;
use Itrvb\Lab4\Http\ErrorResponse;
use Itrvb\Lab4\Http\Request;
use Itrvb\Lab4\Http\Response;
use Itrvb\Lab4\Http\SuccessResponse;

class CreateComment implements ActionInterface
{
    public function __construct(private CreateCommentCommand $command)
    {
    }

    public function handle(Request $request): Response
    {
        try {
            $authorUuid = $request->body('author_uuid');
            $postUuid = $request->body('post_uuid');
            $text = $request->body('text');
            $this->command->handle([
                'authorUuid' => $authorUuid,
                'postUuid' => $postUuid,
                'text' => $text,
            ]);
        } catch (HttpException $ex) {
            return new ErrorResponse($ex->getMessage());
        }

        return new SuccessResponse([
            'message' => 'Comment was created successfully',
            'text' => $text,
        ]);
    }
}
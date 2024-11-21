<?php

namespace Itrvb\Lab4\Http\Actions\Post;

use Itrvb\Lab4\Commands\CreatePostCommand;
use Itrvb\Lab4\Exception\HttpException;
use Itrvb\Lab4\Exception\InvalidUuidException;
use Itrvb\Lab4\Http\Actions\ActionInterface;
use Itrvb\Lab4\Http\ErrorResponse;
use Itrvb\Lab4\Http\Request;
use Itrvb\Lab4\Http\Response;
use Itrvb\Lab4\Http\SuccessResponse;
use Itrvb\Lab4\Repository\Interfaces\UsersRepositoryInterface;
use Symfony\Component\Uid\Uuid;

class CreatePost implements ActionInterface
{
    public function __construct(
        private CreatePostCommand $command,
        private UsersRepositoryInterface $usersRepository,
    ) {
    }

    public function handle(Request $request): Response
    {
        try {
            $authorUuid = $request->body('author_uuid');

            if (!Uuid::isValid($authorUuid)) {
                throw new InvalidUuidException($authorUuid);
            }
            $this->usersRepository->get($authorUuid);

            $title = $request->body('title');
            $text = $request->body('text');
            $this->command->handle([
                'authorUuid' => $authorUuid,
                'title' => $title,
                'text' => $text,
            ]);
        } catch (HttpException $ex) {
            return new ErrorResponse($ex->getMessage());
        }

        return new SuccessResponse([
            'message' => 'Post was created successfully',
            'title' => $title,
            'text' => $text,
        ]);
    }
}

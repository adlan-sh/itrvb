<?php

declare(strict_types = 1);

namespace Itrvb\Lab4\Commands\Comment;

use Itrvb\Lab4\Exception\CommandException;
use Itrvb\Lab4\Model\Comment;
use Itrvb\Lab4\Repository\Interfaces\CommentsRepositoryInterface;
use Symfony\Component\Uid\Uuid;

class CreateCommentCommand
{
    public function __construct(
        private CommentsRepositoryInterface $commentsRepository
    ) {
    }

    public function handle(array $rawInput): void
    {
        $input = $this->parseRawInput($rawInput);

        $this->commentsRepository->save(new Comment(
            Uuid::v4(),
            new Uuid($input['authorUuid']),
            new Uuid($input['postUuid']),
            $input['text'],
        ));
    }

    public function parseRawInput(array $rawInput): array
    {
        $input = [];

        foreach ($rawInput as $key => $argument) {
            if (!str_contains($argument, '=')) {
                $input[$key] = $argument;
                continue;
            }

            $parts = explode('=', $argument);

            if (count($parts) !== 2) {
                continue;
            }

            $input[$parts[0]] = $parts[1];
        }

        foreach (['authorUuid', 'postUuid', 'text'] as $argument) {
            if (!array_key_exists($argument, $input)) {
                throw new CommandException('No required argument provided: ', $argument);
            }

            if (empty($input[$argument])) {
                throw new CommandException('Empty argument provided: ', $argument);
            }
        }

        return $input;
    }
}

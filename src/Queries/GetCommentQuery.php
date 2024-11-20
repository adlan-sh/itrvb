<?php

declare(strict_types = 1);

namespace Itrvb\Lab4\Queries;

use Itrvb\Lab4\Exception\CommandException;
use Itrvb\Lab4\Model\Comment;
use Itrvb\Lab4\Repository\Interfaces\CommentsRepositoryInterface;

class GetCommentQuery
{
    public function __construct(
        private CommentsRepositoryInterface $commentsRepository
    ) {
    }

    public function handle(array $rawInput): Comment
    {
        $input = $this->parseRawInput($rawInput);

        return $this->commentsRepository->get($input['uuid']);
    }

    public function parseRawInput(array $rawInput): array
    {
        $input = [];

        foreach ($rawInput as $argument) {
            $parts = explode('=', $argument);

            if (count($parts) !== 2) {
                continue;
            }

            $input[$parts[0]] = $parts[1];
        }

        foreach (['uuid'] as $argument) {
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

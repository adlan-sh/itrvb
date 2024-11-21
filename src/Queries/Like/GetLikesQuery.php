<?php

declare(strict_types=1);

namespace Itrvb\Lab4\Queries\Like;

use Itrvb\Lab4\Exception\CommandException;
use Itrvb\Lab4\Repository\Interfaces\LikesRepositoryInterface;

class GetLikesQuery
{
    public function __construct(
        private LikesRepositoryInterface $likesRepository
    ) {
    }

    public function handle(array $rawInput): array
    {
        $input = $this->parseRawInput($rawInput);

        return $this->likesRepository->getByPostUuid($input['postUuid']);
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

        foreach (['postUuid'] as $argument) {
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

<?php

declare(strict_types = 1);

namespace Itrvb\Lab4\Commands\Like;

use Itrvb\Lab4\Exception\CommandException;
use Itrvb\Lab4\Exception\LikesAlreadyExistsException;
use Itrvb\Lab4\Model\Like;
use Itrvb\Lab4\Repository\Interfaces\LikesRepositoryInterface;
use Symfony\Component\Uid\Uuid;

class CreateLikeCommand
{
    public function __construct(
        private LikesRepositoryInterface $likesRepository
    ) {
    }

    public function handle(array $rawInput): void
    {
        $input = $this->parseRawInput($rawInput);

        if ($this->likesRepository->isExists($input['postUuid'], $input['userUuid'])) {
            throw new LikesAlreadyExistsException($input['postUuid']);
        }

        $this->likesRepository->save(new Like(
            Uuid::v4(),
            new Uuid($input['postUuid']),
            new Uuid($input['userUuid']),
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

        foreach (['postUuid', 'userUuid'] as $argument) {
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

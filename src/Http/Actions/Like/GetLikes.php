<?php

declare(strict_types = 1);

namespace Itrvb\Lab4\Http\Actions\Like;

use Itrvb\Lab4\Exception\HttpException;
use Itrvb\Lab4\Http\Actions\ActionInterface;
use Itrvb\Lab4\Http\ErrorResponse;
use Itrvb\Lab4\Http\Request;
use Itrvb\Lab4\Http\Response;
use Itrvb\Lab4\Http\SuccessResponse;
use Itrvb\Lab4\Queries\Like\GetLikesQuery;

class GetLikes implements ActionInterface
{
    public function __construct(private GetLikesQuery $query)
    {
    }

    public function handle(Request $request): Response
    {
        try {
            $postUuid = $request->query('post_uuid');
            $data = $this->query->handle([
                'postUuid' => $postUuid,
            ]);
        } catch (HttpException $ex) {
            return new ErrorResponse($ex->getMessage());
        }

        return new SuccessResponse([
            'likes' => $data,
        ]);
    }
}
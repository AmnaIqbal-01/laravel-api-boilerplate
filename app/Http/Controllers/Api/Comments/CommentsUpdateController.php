<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Comments;

use App\Enums\Version;
use App\Models\Comment;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Response;

final class CommentsUpdateController extends Controller
{
    public function __invoke(CommentUpdateRequest $request, Version $version, Comment $comment): JsonResource
    {
//        abort_unless(
//            $version->greaterThanOrEqualsTo(Version::v1_0),
//            Response::HTTP_NOT_FOUND
//        );

        //
    }
}

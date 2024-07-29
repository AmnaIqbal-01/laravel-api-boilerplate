<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Comments;

use App\Enums\Version;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\Api\v1_0\CommentStoreRequest;
use App\Models\Comment;


final class CommentsStoreController extends Controller
{
    public function __invoke(CommentStoreRequest $request, Version $version)
    {
        $comment = Comment::create([
            'rant_id' => $request->input('rant_id'),
            'user_id' => $request->input('user_id'),
            'comment' => $request->input('comment'),
        ]);

        return new JsonResource($comment);

    }
}

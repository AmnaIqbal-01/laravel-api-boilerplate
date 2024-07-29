<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Comments;

use App\Enums\Version;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Response;

final class CommentsDestroyController extends Controller
{
    public function __invoke(Request $request, Version $version, Comment $comment)
    {


        $comment->delete();

        return response()->json([            
            'success' =>true,
            'message' => 'rant is deleted']);
        }
        
}

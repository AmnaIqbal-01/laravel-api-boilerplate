<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Comments;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;
use Illuminate\Support\Facades\Log;
use App\Enums\Version;


final class CommentsIndexController extends Controller
{
    public function __invoke(Request $request,Version $version, $rant_id): JsonResponse
    {
        $user = Auth::user();

        if (!$user) {
            Log::warning('User not authenticated.');
            return response()->json([
                'success' => false,
                'message' => 'User is not authenticated'
            ], JsonResponse::HTTP_UNAUTHORIZED);
        }

        Log::info('Received rant_id:', ['rant_id' => $rant_id]);

        // Retrieve comments by rant_id
        $comments = Comment::where('rant_id', $rant_id)->get();

        Log::info('Comments retrieved:', ['comments' => $comments]);

        if ($comments->isEmpty()) {
            Log::info('No comments found for the given rant_id.', ['rant_id' => $rant_id]);
            return response()->json([
                'success' => false,
                'message' => 'No comments found'
            ], JsonResponse::HTTP_NOT_FOUND);
        }

        // Return comments as JSON
        return response()->json([
            'success' => true,
            'data' => $comments
        ], JsonResponse::HTTP_OK);
    }
}

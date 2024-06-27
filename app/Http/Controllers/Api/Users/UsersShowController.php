<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Users;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Enums\Version;
use App\Http\Resources\v1_0\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

final class UsersShowController extends Controller
{
    public function __invoke(Request $request, Version $version): JsonResource
    {
        $authenticatedUser = Auth::user();
        
        if (!$authenticatedUser) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], Response::HTTP_UNAUTHORIZED);
        }


        return UserResource::make($authenticatedUser);
    }
}

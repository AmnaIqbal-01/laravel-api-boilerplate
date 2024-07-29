<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Users;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Enums\Version;
use App\Http\Requests\Api\v1_0\UserUpdateRequest;
use App\Http\Resources\v1_0\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

final class UsersUpdateController extends Controller
{
    public function __invoke(UserUpdateRequest $request, Version $version)
    {
        Log::info('Raw request data', ['data' => $request->all()]);

        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $data = $request->except('profile_pic');

        if ($request->hasFile('profile_pic')) {
            // Store the profile picture and get the path
            $path = $request->file('profile_pic')->store('profile_pics', 'public');
            $data['profile_pic'] = $path;
        }

        // Update the user's information
        $user->update($data);

        // Log the updated user data
        Log::info('Updated user data', ['user' => $user->refresh()]);

        // Return the updated user resource
        return new UserResource($user->refresh());
    }
}

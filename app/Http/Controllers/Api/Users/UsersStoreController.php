<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api\Users;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Enums\Version;
use App\Http\Resources\v1_0\UserResource;
use App\Http\Requests\Api\v1_0\UserStoreRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Laravel\Sanctum\HasApiTokens;



class UsersStoreController extends Controller
{
    public function __invoke(UserStoreRequest $request, Version $version)
    {
        // Perform validation
        $validatedData = $request->validated();
    // Create user
    $user = User::create([
        'name' => $validatedData['name'],
        'email' => $validatedData['email'],
        'username' => $validatedData['username'],
        'password' => Hash::make($validatedData['password']),
        'first_name' => ucfirst($validatedData['first_name']),
        'about' => $validatedData['about'] ?? null,
        'profile_pic' => $validatedData['profile_pic'] ?? null,
    ]);

    // Generate auth token
    $token = $user->createToken('auth')->plainTextToken;

    // Return user resource with token
    return UserResource::make($user)->additional(['token' => $token]);
    }

    public function test(UserStoreRequest $request, Version $version, User $user){
     Log::info('test');
    
     $validated = $request->validated();

     // Create a new user instance and save it to the database...
     $user = User::create([
         'id' => (string) Str::uuid(),
         'name' => $validated['name'],
         'email' => $validated['email'],
         'username' => $validated['username'],
         'about' => $validated['about'],
         'profile_pic' => $validated['profile_pic'],
         'password' => Hash::make($validated['password']),


     ]);
     $token = $user->createToken('auth')->plainTextToken;

     // Return the created user and version as part of the response.
     return response()->json([
         'user' => new UserResource($user),
         'token' => $token,
        ], Response::HTTP_CREATED);
 }
}

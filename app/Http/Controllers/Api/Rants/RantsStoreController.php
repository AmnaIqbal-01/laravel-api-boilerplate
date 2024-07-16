<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Rants;

use App\Enums\Version;
use App\Http\Requests\Api\v1_0\RantStoreRequest;
use App\Models\Rant;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;


final class RantsStoreController extends Controller
{
    public function __invoke(RantStoreRequest $request, Version $version)
    {
        $user = Auth::user();

        $data = $request->validated();
        $data['user_id'] = $user->id;

        $rant = Rant::create($data);

        return response()->json([
            'message' => 'Rant created successfully',
            'rant' => $rant
        ], Response::HTTP_CREATED);
    }

}


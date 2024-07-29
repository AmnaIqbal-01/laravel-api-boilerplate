<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Rants;

use App\Enums\Version;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Rant;
use Illuminate\Support\Facades\Auth;



final class RantsIndexController extends Controller
{
    public function __invoke(Request $request, Version $version)
    {
        $user = Auth::user();

        if(!$user){
        return response()->json([
            'success' => false,
            'data' => 'user is not authenticated'
        ]);
        }
        $rants = Rant::all();


        // You can use a resource collection for transformation if necessary
        return response()->json([
            'success' => true,
            'data' => $rants
        ]);
    }
}

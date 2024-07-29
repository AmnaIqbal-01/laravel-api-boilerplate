<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Rants;

use App\Enums\Version;
use App\Models\Rant;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Response;

final class RantsDestroyController extends Controller
{
    public function __invoke(Request $request, Version $version, Rant $rant)
    {

    $rant->delete();

    return response()->json([            
        'success' =>true,
        'message' => 'rant is deleted']);
    }
}

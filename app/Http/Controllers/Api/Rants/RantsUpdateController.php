<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Rants;

use App\Enums\Version;
use App\Models\Rant;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Response;

final class RantsUpdateController extends Controller
{
    public function __invoke(RantUpdateRequest $request, Version $version, Rant $rant): JsonResource
    {
//        abort_unless(
//            $version->greaterThanOrEqualsTo(Version::v1_0),
//            Response::HTTP_NOT_FOUND
//        );

        //
    }
}

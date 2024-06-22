<?php

declare(strict_types=1);

namespace App\Http\Resources\v1_0;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class RantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}

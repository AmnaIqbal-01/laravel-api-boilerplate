<?php

declare(strict_types=1);

namespace App\Http\Resources\v1_0;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin User
 */
final class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'name'       => $this->name,
            'email'      => $this->email, // email address is considered a sensitive data, we advise you to avoid exposing it on public!
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'username'   =>$this->username,
            'about'      =>$this->about,
            'profile_pic'=>$this->profile_pic,
            
        ];
    }
}

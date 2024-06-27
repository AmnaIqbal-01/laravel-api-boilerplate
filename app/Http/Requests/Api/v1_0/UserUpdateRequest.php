<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\v1_0;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @mixin User
 */
final class UserUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
           'name' => ['sometimes', 'string', 'max:255'],
            'username' => ['sometimes', 'string', 'max:255'],
            'about' => ['sometimes', 'nullable', 'string'],
            'profile_pic' => ['sometimes', 'image', 'mimes:jpeg,png,jpg', 'max:1024'], // Accepting jpeg, png, jpg
        ];
    }
}

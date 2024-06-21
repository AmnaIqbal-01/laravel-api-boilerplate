<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Concerns\InteractsWithUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class VerificationCode extends Model
{
    use HasFactory;
    protected $fillable = [
        'code',
        'email'
    ];
}

<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Concerns\InteractsWithUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class Comment extends Model
{
    use HasFactory;
    use InteractsWithUuid;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'rant_id',
        'user_id',
        'comment',
    ];

    /**
     * Define the relationship with the Rant model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rant()
    {
        return $this->belongsTo(Rant::class, 'rant_id'); 
    }
  
    /**
     * Define the relationship with the User model (the owner of the rant).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); 
    }
}

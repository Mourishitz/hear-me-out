<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rating extends Model
{
    protected $fillable = [
        'value',
        'notes',
        'criteria',
        'ratable_id',
        'ratable_type',
    ];

    /**
     * @return BelongsTo<User,Rating>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

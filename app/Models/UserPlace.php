<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserPlace extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'city_id',
        'type',
        'date_moved',
    ];

    protected $casts = [
        'date_moved' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }
}

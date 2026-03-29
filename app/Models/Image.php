<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'imageable_id',
        'imageable_type',
        'type',
        'path',
        'disk',
        'file_name',
        'mime_type',
        'size',
        'order_column',
    ];

    public function imageable(): MorphTo
    {
        return $this->morphTo();
    }
}

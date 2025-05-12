<?php

namespace App\Models;

use Database\Factories\ImageFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Image extends Model
{
    /** @use HasFactory<ImageFactory> */
    use HasFactory;



    public function apartment(): BelongsTo
    {
        return $this->belongsTo(Apartment::class);
    }
}

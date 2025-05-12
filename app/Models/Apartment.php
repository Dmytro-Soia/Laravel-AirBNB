<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Apartment extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'rooms',
        'max_people',
        'price',
        'country',
        'city',
        'street'
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'apartment_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(Image::class);
    }
}

<?php

namespace App\Models;

use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'reserved_at',
        'expired_at',
    ];
    public function apartment(): BelongsTo
    {
        return $this->belongsTo(Apartment::class);
    }
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function daysDifference($dateFrom, $dateTo)
    {
        $daysDiff = strtotime($dateTo) - strtotime($dateFrom);
        return CarbonInterval::seconds($daysDiff)->totalDays;
    }
}

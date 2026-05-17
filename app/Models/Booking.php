<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Booking extends Model
{
    protected $fillable = [
        'destination_id',
        'customer_name',
        'customer_email',
        'start_date',
        'end_date',
        'num_travelers',
        'total_price',
        'booking_reference',
        'status',
    ];

    /**
     * Boot function to auto-generate unique booking references
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($booking) {
            $booking->booking_reference = 'TS-' . strtoupper(Str::random(6));
        });
    }

    /**
     * Relationship with Destination
     */
    public function destination(): BelongsTo
    {
        return $this->belongsTo(Destination::class);
    }
}

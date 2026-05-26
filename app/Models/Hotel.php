<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Hotel extends Model
{
    use HasFactory;

    protected $fillable = [
        'destination_id',
        'name',
        'type',
        'location',
        'description',
        'price_per_night',
        'rating',
        'rooms_available',
        'amenities',
        'image_url',
        'latitude',
        'longitude'
    ];

    protected $casts = [
        'amenities' => 'array',
        'price_per_night' => 'float',
        'rating' => 'float',
        'latitude' => 'float',
        'longitude' => 'float'
    ];

    /**
     * Get the destination this hotel belongs to.
     */
    public function destination(): BelongsTo
    {
        return $this->belongsTo(Destination::class);
    }

    /**
     * Get bookings made for this hotel.
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
}

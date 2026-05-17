<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'location', 'description', 'min_budget', 'max_budget', 'best_months', 'image_url'
    ];

    protected $casts = [
        'best_months' => 'array',
        'min_budget' => 'float',
        'max_budget' => 'float',
    ];

    public function activities()
    {
        return $this->belongsToMany(Activity::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Companion extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'passport_number',
        'birth_date',
        'relationship',
    ];

    /**
     * Relationship with User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

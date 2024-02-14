<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserSlotsSpin extends Model
{
    use HasFactory,
        HasTimestamps,
        SoftDeletes;

    protected $fillable = [
        'slot_symbols',
        'credits_quantity_won',
        'credits_quantity_bet',
        'user_id',
    ];

    protected $casts = [
        'slot_symbols' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeWithWinnings($query)
    {
        return $query->where('credits_quantity_won', '>', 0);
    }
}

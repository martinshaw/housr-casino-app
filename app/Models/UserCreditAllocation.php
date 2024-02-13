<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserCreditAllocation extends Model
{
    use HasFactory,
        SoftDeletes,
        HasTimestamps;

    protected $fillable = [
        'quantity_allocated',
        'quantity_used',

        'user_id',
    ];

    protected $casts = [
        'quantity_allocated' => 'integer',
        'quantity_used' => 'integer',

        'user_id' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

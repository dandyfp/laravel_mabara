<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
      protected $fillable = [
        'session_id',
        'player_name',
        'play_count',
        'shuttlecock_count',
        'court_fee',
        'shuttlecock_fee',
        'total_fee',
        'payment_method',
        'payment_status',
        'paid_at'
    ];

    public function session()
    {
        return $this->belongsTo(GameSession::class);
    }
}

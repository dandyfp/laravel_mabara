<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameSession extends Model
{
    protected $fillable = ['session_date', 'opening_balance'];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function cashLedger()
    {
        return $this->hasOne(CashLedger::class);
    }
}

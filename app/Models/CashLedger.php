<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CashLedger extends Model
{
    protected $fillable = [
        'session_id',
        'total_income',
        'closing_balance'
    ];

    public function session()
    {
        return $this->belongsTo(Session::class);
    }
}

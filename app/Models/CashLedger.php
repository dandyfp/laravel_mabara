<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CashLedger extends Model
{
    protected $fillable = [
        'user_id',
        'session_id',
        'description',      // Untuk catat: "Bayar Lapangan", "Beli Air", dll
        'type',             // 'in' untuk uang masuk, 'out' untuk uang keluar
        'amount',           // Nominal transaksi
        'current_balance',  // Saldo kas saat itu
    ];

    public function session()
    {
        return $this->belongsTo(Session::class);
    }
}

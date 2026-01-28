<?php

namespace App\Services;

use App\Models\CashLedger;
use Illuminate\Support\Facades\DB;

class CashService
{
    /**
     * Fungsi utama untuk mencatat mutasi kas (In/Out)
     */
    public function recordMutation($sessionId, $description, $type, $amount)
    {
        return DB::transaction(function () use ($sessionId, $description, $type, $amount) {
            // 1. Ambil saldo terakhir dari CashLedger
            $lastRecord = CashLedger::latest('id')->first();
            $lastBalance = $lastRecord ? $lastRecord->current_balance : 0;

            // 2. Hitung saldo baru
            $newBalance = ($type === 'in') 
                ? $lastBalance + $amount 
                : $lastBalance - $amount;

            // 3. Simpan ke Buku Besar (CashLedger)
            return CashLedger::create([
                'session_id'      => $sessionId,
                'description'     => $description,
                'type'            => $type,
                'amount'          => $amount,
                'current_balance' => $newBalance,
            ]);
        });
    }
}
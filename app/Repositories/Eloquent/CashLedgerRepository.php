<?php
namespace App\Repositories\Eloquent;

use App\Models\CashLedger;
use App\Models\Transaction;
use App\Repositories\Contracts\CashLedgerRepositoryInterface;

class CashLedgerRepository implements CashLedgerRepositoryInterface
{
    public function recalculate(int $sessionId): void
    {
        $total = Transaction::where('session_id', $sessionId)
            ->where('payment_status', 'paid')
            ->sum('total_fee');

        CashLedger::updateOrCreate(
            ['session_id' => $sessionId],
            [
                'total_income' => $total,
                'closing_balance' => $total
            ]
        );
    }
}

<?php
namespace App\Repositories\Eloquent;

use App\Models\Transaction;
use App\Repositories\Contracts\TransactionRepositoryInterface;

class TransactionRepository implements TransactionRepositoryInterface
{
    public function create(array $data): Transaction
    {
        return Transaction::create($data);
    }

    public function markAsPaid(int $id): Transaction
    {
        $trx = Transaction::findOrFail($id);
        $trx->update([
            'payment_status' => 'paid',
            'paid_at' => now()
        ]);

        return $trx;
    }

    public function getBySession(int $sessionId)
    {
        return Transaction::where('session_id', $sessionId)->get();
    }

    public function update(int $id, array $data): Transaction
    {
        $trx = Transaction::findOrFail($id);
        $trx->update($data);
        return $trx;
    }

    public function find(int $id): Transaction
    {
        return Transaction::findOrFail($id);
    }

}

<?php

namespace App\Services;

use App\Repositories\Contracts\GameSessionRepositoryInterface;
use App\Models\Transaction;

class GameSessionService
{
    public function __construct(
        protected GameSessionRepositoryInterface $repository
    ) {}

    public function createSession(array $data)
    {
        return $this->repository->getOrCreateToday($data);
    }

    public function summary(int $sessionId): array
    {
        $transactions = $this->repository->getBySession($sessionId);

        return [
            'total_income' => $transactions->sum('total_fee'),
            'paid' => $transactions->where('payment_status', 'paid')->sum('total_fee'),
            'unpaid' => $transactions->where('payment_status', 'pending')->sum('total_fee'),
        ];
    }
    public function dailyReport(string $date): array
    {
        $transactions = Transaction::whereDate('created_at', $date)->get();

        return [
            'date' => $date,
            'summary' => [
                'total_income' => $transactions->sum('total_fee'),
                'paid' => $transactions->where('payment_status', 'paid')->sum('total_fee'),
                'unpaid' => $transactions->where('payment_status', 'pending')->sum('total_fee'),
            ],
            'players' => $transactions->map(fn ($trx) => [
                'player_name' => $trx->player_name,
                'play_count' => $trx->play_count,
                'total_fee' => $trx->total_fee,
                'status' => $trx->payment_status,
            ])->values()
        ];
    }

}

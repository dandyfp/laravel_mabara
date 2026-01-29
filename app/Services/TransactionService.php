<?php

namespace App\Services;

use App\Repositories\Contracts\TransactionRepositoryInterface;
use App\Repositories\Contracts\GameSessionRepositoryInterface;
use App\Services\CashService;



class TransactionService
{
    public function __construct(
        protected TransactionRepositoryInterface $transactionRepository,
        protected GameSessionRepositoryInterface $gameSessionRepository
    ) {}

    public function createTransaction(array $data)
    {
        $session = $this->gameSessionRepository->getOrCreateToday();

        $playCount = $data['play_count'] ?? 0;
        $cockCount = $data['shuttlecock_count'] ?? 0;

        $fees = $this->calculate($playCount, $cockCount);

        return $this->transactionRepository->create([
            'session_id'        => $session->id,
            'player_name'       => $data['player_name'],
            'play_count'        => $playCount,
            'court_fee'         => $fees['court_fee'],
            'shuttlecock_count' => $cockCount,
            'shuttlecock_fee'   => $fees['shuttlecock_fee'],
            'total_fee'         => $fees['total_fee'],
            'payment_status'    => 'pending',
        ]);
    }

    public function calculate($playCount, int $cockCount): array
    {
        $count = (int) $playCount;

        $courtFee = match ($count) {
            1 => 8000,
            2 => 10000,
            3 => 12000,
            default => 0 
        };

        $cockFee = $cockCount * 3000;

        return [
            'court_fee' => $courtFee,
            'shuttlecock_fee' => $cockFee,
            'total_fee' => $courtFee + $cockFee
        ];
    }

    public function markAsPaid(int $id)
    {
        // 1. Biarkan Repository melakukan Toggle (Paid <-> Pending)
        $transaction = $this->transactionRepository->markAsPaid($id);

        // 2. CEK HASILNYA: Statusnya sekarang apa?
        if ($transaction->payment_status === 'paid') {
            
            // KASUS A: Jadi LUNAS (Uang Masuk)
            app(CashService::class)->recordMutation(
                $transaction->session_id,
                "Pembayaran Mabar: " . $transaction->player_name,
                'in', // <--- Tipe Masuk
                $transaction->total_fee
            );

        } else {
            
            // KASUS B: Jadi PENDING / BATAL (Uang Keluar/Koreksi)
            // Kita catat sebagai pengeluaran agar saldo kas berkurang kembali
            app(CashService::class)->recordMutation(
                $transaction->session_id,
                "Koreksi Pembayaran: " . $transaction->player_name,
                'out', // <--- Tipe Keluar (PENTING!)
                $transaction->total_fee
            );
        }

        return $transaction;
    }

    public function updateTransaction(int $id, array $data)
    {
        // Hitung ulang biaya berdasarkan data baru yang dikirim admin
        $fees = $this->calculate(
            (int) $data['play_count'],
            (int) $data['shuttlecock_count']
        );

        $updateData = array_merge($data, [
            'court_fee'       => $fees['court_fee'],
            'shuttlecock_fee' => $fees['shuttlecock_fee'],
            'total_fee'       => $fees['total_fee'],
        ]);

        return $this->transactionRepository->update($id, $updateData);
    }
}

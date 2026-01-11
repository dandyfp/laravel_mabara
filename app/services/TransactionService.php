<?php
namespace App\Services;

class TransactionService
{
    public function calculate(int $playCount, int $cockCount): array
    {
        $courtFee = match ($playCount) {
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
}

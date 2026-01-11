<?php
namespace App\Repositories\Contracts;

interface CashLedgerRepositoryInterface
{
    public function recalculate(int $sessionId): void;
}

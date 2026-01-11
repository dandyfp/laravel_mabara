<?php
namespace App\Repositories\Eloquent;

use App\Models\GameSession;
use App\Repositories\Contracts\GameSessionRepositoryInterface;

class GameSessionRepository implements GameSessionRepositoryInterface
{
    public function getOrCreateToday(): GameSession
    {
        return GameSession::firstOrCreate(
            ['session_date' => now()->toDateString()],
            ['opening_balance' => 0]
        );
    }
}

<?php
namespace App\Repositories\Contracts;

use App\Models\GameSession;

interface GameSessionRepositoryInterface
{
    public function getOrCreateToday(): GameSession;
}

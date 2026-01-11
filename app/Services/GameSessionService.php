<?php

namespace App\Services;

use App\Repositories\Contracts\GameSessionRepositoryInterface;

class GameSessionService
{
    public function __construct(
        protected GameSessionRepositoryInterface $repository
    ) {}

    public function createSession(array $data)
    {
        // nanti logic hitung biaya masuk di sini
        return $this->repository->getOrCreateToday($data);
    }
}

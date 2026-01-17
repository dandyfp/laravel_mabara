<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GameSessionService;

class GameSessionController extends Controller
{
    public function __construct(
        protected GameSessionService $gameSessionService
    ) {}

    public function store(Request $request)
    {
        return response()->json(
            $this->gameSessionService->createSession($request->all()),
            201
        );
    }
    public function summary(int $sessionId)
    {
        return response()->json(
            $this->gameSessionService->summary($sessionId),201
        );
    }
}

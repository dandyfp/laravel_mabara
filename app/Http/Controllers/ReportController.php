<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GameSessionService;


class ReportController extends Controller
{
    public function daily(Request $request)
    {
        $date = $request->query('date', now()->toDateString());

        $data = app(GameSessionService::class)->dailyReport($date);

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
        
    }
}

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
    
        // Jika request meminta JSON (misal dari Insomnia/Postman/AJAX)
        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        }
    
        // Jika dibuka langsung dari browser, tampilkan halaman Blade
        return view('transactions.index', [
            'report' => $data
        ]);
    }
}

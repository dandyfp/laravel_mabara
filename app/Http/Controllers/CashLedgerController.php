<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CashLedger; // Pastikan ini diimport

class CashLedgerController extends Controller
{
    public function index(Request $request)
    {
        $query = CashLedger::query();

        // Filter Date Range (Sesuaikan start/end dengan input di UI)
        if ($request->filled('start') && $request->filled('end')) {
            $query->whereBetween('created_at', [$request->start . ' 00:00:00', $request->end . ' 23:59:59']);
        }

        $ledgers = $query->latest('id')->get();

        // Ambil saldo penutupan terakhir secara real-time
        $lastRecord = CashLedger::latest('id')->first();
        $closing_balance = $lastRecord ? $lastRecord->current_balance : 0;

        return view('admin.cash.ledger', compact('ledgers', 'closing_balance'));
    }
}
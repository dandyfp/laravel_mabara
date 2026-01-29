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

    // Tambahkan method ini di dalam class CashLedgerController

    public function storeIncome(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'description' => 'required|string|max:255',
            'date' => 'required|date',
        ]);
            // 1. Cari Saldo Terakhir di database
        // Kita ambil data paling baru berdasarkan ID
        $lastLedger = \App\Models\CashLedger::latest('id')->first();

        // Jika ada data sebelumnya, ambil current_balance-nya. Jika tidak ada (data pertama), set 0.
        $lastBalance = $lastLedger ? $lastLedger->current_balance : 0;

        // 2. Hitung Saldo Baru (Karena ini Pemasukan, maka DITAMBAH)
        $newBalance = $lastBalance + $request->amount;

        CashLedger::create([
            'session_id' => null,
            'user_id' => auth()->id(),
            'date' => $request->date,
            'type' => 'in', // PENTING: Type 'in' artinya uang masuk
            'amount' => $request->amount,
            'description' => $request->description,
            'current_balance' => $newBalance
        ]);

        return back()->with('success', 'Saldo berhasil ditambahkan!');
    }
}
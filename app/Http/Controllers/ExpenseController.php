<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;
use App\Models\CashLedger; // Tambahkan ini
use App\Models\GameSession; // Tambahkan ini jika butuh session_id
use Illuminate\Support\Facades\DB;

class ExpenseController extends Controller
{
    public function index(Request $request) {
        $query = Expense::query();

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('date', [$request->start_date, $request->end_date]);
        }

        $expenses = $query->orderBy('date', 'desc')->get();
        $total_expense = $expenses->sum('amount');

        return view('admin.expenses.index', compact('expenses', 'total_expense'));
    }

    public function store(Request $request) {
        $data = $request->validate([
            'name' => 'required|string',
            'amount' => 'required|numeric',
            'date' => 'required|date',
        ]);

        // Gunakan Database Transaction agar jika salah satu gagal, semua dibatalkan
        DB::transaction(function () use ($data) {
            // 1. Simpan ke tabel Expenses
            Expense::create($data);

            // 2. Cari saldo terakhir di CashLedger
            $lastLedger = CashLedger::latest('id')->first();
            $lastBalance = $lastLedger ? $lastLedger->current_balance : 0;

            // 3. Catat mutasi keluar di CashLedger
            CashLedger::create([
                // Kita ambil session hari ini atau null jika pengeluaran umum
                'session_id' => GameSession::where('session_date', $data['date'])->first()?->id,
                'description' => "Pengeluaran: " . $data['name'],
                'type' => 'out',
                'amount' => $data['amount'],
                'current_balance' => $lastBalance - $data['amount'],
            ]);
        });

        return back()->with('success', 'Pengeluaran dicatat dan saldo kas dipotong!');
    }
}
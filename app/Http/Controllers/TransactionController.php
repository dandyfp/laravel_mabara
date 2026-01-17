<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreTransactionRequest;
use App\Services\TransactionService;

class TransactionController extends Controller
{
   
    public function __construct(
        protected TransactionService $service
    ) {}

    public function store(StoreTransactionRequest $request)
    {
        $trx = $this->service->createTransaction($request->validated());

        // Cek jika request datang dari Postman / API call
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'data' => $trx
            ], 201);
        }

        // Jika datang dari Form Web (Browser)
        return redirect()->route('transactions.index')
            ->with('success', 'Data berhasil dicatat! Silakan konfirmasi ke admin.');
    }

    public function markPaid(int $id)
    {
        $trx = $this->service->markAsPaid($id);
        if (!request()->expectsJson()) {
            return redirect()->back()->with('success', 'Status pembayaran berhasil diperbarui!');
        }

        return response()->json([
            'success' => true,
            'data' => $trx
        ]);
    }

    public function update(Request $request, $id)
    {
        // Gunakan service Anda untuk update data
        $this->service->updateTransaction($id, $request->only([
            'player_name', 'play_count', 'shuttlecock_count'
        ]));
    
        return redirect()->back()->with('success', 'Data pemain berhasil diperbarui!');
    }

}

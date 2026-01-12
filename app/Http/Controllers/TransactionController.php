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

        return response()->json([
            'success' => true,
            'data' => $trx
        ], 201);
    }
}

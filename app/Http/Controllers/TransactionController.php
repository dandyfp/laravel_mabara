<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TransactionService;

class TransactionController extends Controller
{
   
    public function __construct(
        protected TransactionService $service
    ) {}

    public function store(Request $request)
    {
        $trx = $this->service->createTransaction($request->all());

        return response()->json([
            'success' => true,
            'data' => $trx
        ], 201);
    }
}

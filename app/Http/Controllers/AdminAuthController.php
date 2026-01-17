<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminAuthController extends Controller
{
    public function showLoginForm() {
        return view('login');
    }

    public function login(Request $request) {
        // Ganti dengan password pilihan Anda
        if ($request->password === 'mabara2026') {
            session(['is_admin' => true]);
            return redirect()->route('transactions.index')->with('success', 'Halo Admin!');
        }
        return back()->with('error', 'Password salah!');
    }

    public function logout() {
        session()->forget('is_admin');
        return redirect()->route('home');
    }

    public function update(Request $request, $id) 
    {
        $this->service->updateTransaction($id, $request->all());
        return redirect()->back()->with('success', 'Data diperbarui!');
    }
}
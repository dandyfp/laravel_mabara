<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use App\Http\Requests\LoginRequest; 

class AdminAuthController extends Controller
{
    public function showLoginForm() {
        return view('login');
    }

    public function login(LoginRequest $request) {
        // Validasi otomatis dijalankan oleh LoginRequest
        if (Auth::attempt($request->validated())) {
            $request->session()->regenerate();
            return redirect()->route('transactions.index')->with('success', 'Halo Admin!');
        }

        return back()->with('error', 'Email atau password salah!');
    }

    public function logout(Request $request) {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
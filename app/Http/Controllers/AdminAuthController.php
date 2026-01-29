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
        if (Auth::attempt($request->validated(), true)) {

            if (Auth::user()->is_admin) {
                $request->session()->regenerate();
                return redirect()->route('transactions.index')
                ->with('success', 'Halo Admin!')
                ->withInput($request->only('email'));
            }

            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->with('error', 'Maaf, kamu bukan admin!');
        }

        return back()
        ->with('error', 'Email atau password salah!')
        ->withInput($request->only('email'));
    }

    public function logout(Request $request) {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    
}
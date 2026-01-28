<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegistrationRequest;
use App\Repositories\Contracts\UserRepositoryInterface; 
use Illuminate\Support\Facades\Auth;

class RegistrationController extends Controller
{
    protected $userRepo;

    public function __construct(UserRepositoryInterface $userRepo)
    {
        $this->userRepo = $userRepo;
    }
    public function showRegistrationForm(){
        return view('auth.register');
    }

    public function register(RegistrationRequest $request)
    {
        $user = $this->userRepo->create($request->validated());

        Auth::login($user);

        return redirect()->route('login')->with('success','Akun berhasil dibuat, silakan login admin.');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminUtilityController extends Controller
{
    public function promoteToAdmin(Request $request)
    {
        // 1. Cek Kunci Rahasia (Security Layer)
        // Pastikan ADMIN_SECRET_KEY sudah ada di file .env
        $secretKey = env('ADMIN_SECRET_KEY');

        if (!$secretKey) {
            return response()->json([
                'status' => 'error',
                'message' => 'Konfigurasi server belum lengkap (Secret Key belum diset).'
            ], 500);
        }

        if ($request->query('key') !== $secretKey) {
            return response()->json([
                'status' => 'error',
                'message' => 'Akses ditolak! Kunci salah.'
            ], 403);
        }

        // 2. Validasi Email
        $email = $request->query('email');
        if (!$email) {
            return response()->json([
                'status' => 'error', 
                'message' => 'Parameter email wajib diisi'
            ], 400);
        }

        // 3. Cari User
        $user = User::where('email', $email)->first();

        if (!$user) {
            return response()->json([
                'status' => 'error', 
                'message' => 'User dengan email tersebut tidak ditemukan'
            ], 404);
        }

        // 4. Cek apakah sudah admin? (Opsional, agar tidak update berulang)
        if ($user->is_admin) {
            return response()->json([
                'status' => 'info',
                'message' => "User {$user->name} SUDAH menjadi admin sebelumnya.",
                'data' => $user
            ]);
        }

        // 5. Ubah Jadi Admin
        $user->is_admin = true;
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => "Hore! User {$user->name} ({$user->email}) sekarang adalah ADMIN.",
            'data' => $user
        ]);
    }
}
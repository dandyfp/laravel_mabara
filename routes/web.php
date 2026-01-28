<?php   
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\CashLedgerController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
// Halaman Landing
Route::get('/', function () {
    return view('landing');
})->name('home');

// Halaman List (Menampilkan data report)
Route::get('/transactions', [ReportController::class, 'daily'])->name('transactions.index');

// Rute Simpan (Yang dipanggil oleh form landing)
Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');

// Auth Admin
Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AdminAuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

// Admin Actions (Proteksi dengan middleware auth/custom jika perlu)
Route::patch('/transactions/{id}/status', [TransactionController::class, 'markPaid'])->name('admin.mark-paid');
Route::put('/transactions/{id}', [TransactionController::class, 'update'])->name('admin.update-transaction');
Route::delete('/transactions/{id}', [TransactionController::class, 'destroy'])->name('admin.delete-transaction');

// Halaman Form Registrasi
Route::get('/register', [RegistrationController::class, 'showRegistrationForm'])->name('register');
    
// Proses pengiriman data Registrasi
Route::post('/register', [RegistrationController::class, 'register']);

Route::get('/logout-manual', function () {
    Auth::logout();
    Session::flush();
    return redirect('/register')->with('success', 'Berhasil logout, sekarang kamu bisa daftar lagi.');
});

Route::get('/cash-ledger', [App\Http\Controllers\CashLedgerController::class, 'index'])->name('cash.ledger');


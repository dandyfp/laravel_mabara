<?php   
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AdminAuthController;
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

Route::get('/jalankan-migrasi-mabara', function () {
    Artisan::call('migrate:fresh', ['--force' => true]);
    return "Migrasi Berhasil!";
});
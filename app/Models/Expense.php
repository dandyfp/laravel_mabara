<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    // Mass assignment: daftar kolom yang boleh diisi melalui form/array
    protected $fillable = [
        'name',     // Contoh: Beli Shuttlecock
        'amount',   // Harga
        'date',     // Tanggal pengeluaran
        'note',     // Catatan tambahan (opsional)
        'category'  // Kategori: 'court', 'shuttlecock', 'drink', 'other'
    ];

    /**
     * Jika kamu ingin menghubungkan pengeluaran dengan sesi mabar tertentu.
     * (Opsional, tergantung struktur databasemu)
     */
    public function session()
    {
        return $this->belongsTo(GameSession::class, 'session_id');
    }
}
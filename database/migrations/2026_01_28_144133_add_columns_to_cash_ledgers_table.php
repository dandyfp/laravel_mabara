<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('cash_ledgers', function (Blueprint $table) {
                // Tambahkan kolom yang dibutuhkan oleh sistem Ledger baru
            $table->string('description')->after('session_id');
            $table->enum('type', ['in', 'out'])->after('description');
            $table->decimal('amount', 12, 2)->after('type');
            $table->decimal('current_balance', 12, 2)->after('amount');

            // Hapus kolom lama yang sudah tidak dipakai (jika ada)
            if (Schema::hasColumn('cash_ledgers', 'total_income')) {
                $table->dropColumn(['total_income', 'closing_balance']);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cash_ledgers', function (Blueprint $table) {
           $table->dropColumn(['description', 'type', 'amount', 'current_balance']);
        });
    }
};

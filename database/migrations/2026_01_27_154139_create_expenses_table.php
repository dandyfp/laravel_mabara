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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id()->uuid();
            $table->string('name'); // Contoh: Beli Shuttlecock 1 Slop
            $table->integer('amount'); // Harga
            $table->date('date'); // Tanggal pengeluaran
            $table->string('category')->nullable(); // Opsional: Shuttlecock, Lapangan, Minum
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};

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
        Schema::create('cash_ledgers', function (Blueprint $table) {
           $table->id()->uuid();

            $table->foreignId('session_id')
                  ->constrained('game_sessions')
                  ->cascadeOnDelete()
                  ->unique();

            $table->integer('total_income')->default(0);
            $table->integer('closing_balance')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cash_ledgers');
    }
};

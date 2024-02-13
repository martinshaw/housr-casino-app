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
        Schema::create('user_slots_spins', function (Blueprint $table) {
            $table->id();

            $table->json('slot_symbols')->nullable();
            $table->integer('credits_quantity_won')->default(0);
            $table->integer('credits_quantity_bet')->default(0);

            $table->foreignId('user_id')->constrained('users');
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_slots_spins');
    }
};

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
        Schema::create('usersmc_locals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('users_ticket_server_id')
                  ->constrained('users_ticket_server')
                  ->cascadeOnDelete()
                  ->cascadeOnUpdate();
            $table->foreignId('local_id')
                  ->constrained()
                  ->cascadeOnDelete()
                  ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usersmc_locals');
    }
};

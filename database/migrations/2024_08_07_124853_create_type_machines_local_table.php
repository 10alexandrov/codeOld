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
        Schema::create('type_machines_local', function (Blueprint $table) {
            $table->id();
            $table->foreignId('type_machine_id')
                  ->constrained('type_machines')
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
        Schema::dropIfExists('type_machines_local');
    }
};

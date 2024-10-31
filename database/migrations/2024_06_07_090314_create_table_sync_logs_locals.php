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

        Schema::create('sync_logs_locals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('local_id')->constrained()->onDelete('cascade')->onUpdate('cascade'); // Definir la clave foránea
            $table->string('status', 50);
            $table->text('message')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sync_logs_locals');
    }
};

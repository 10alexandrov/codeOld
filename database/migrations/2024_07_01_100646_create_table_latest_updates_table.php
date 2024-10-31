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
        Schema::create('latest_updates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('local_id')->constrained()->onDelete('cascade')->onUpdate('cascade'); // Definir la clave foránea
            $table->string('table');
            $table->timestamps();
            $table->string('latest_update');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('latest_updates');
    }
};

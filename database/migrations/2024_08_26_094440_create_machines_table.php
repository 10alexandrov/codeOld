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
        Schema::create('machines', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('alias');

            // Relación opcional con la tabla locals
            $table->foreignId('local_id')
                ->nullable()
                ->constrained('locals')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            // Relación opcional con la tabla bars
            $table->foreignId('bar_id')
                ->nullable()
                ->constrained('bars')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreignId('delegation_id')
                ->nullable()
                ->constrained('delegations')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->string('identificador');
            $table->timestamps();

            // Restricción única para asegurar que una máquina no esté en ambos simultáneamente
            $table->unique(['local_id', 'bar_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('machines');
    }
};

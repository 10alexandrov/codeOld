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
        Schema::create('auxiliares', function (Blueprint $table) {
            $table->id();
            $table->foreignId('machine_id')
            ->constrained()
            ->cascadeOnDelete()
            ->cascadeOnUpdate();
            $table->integer("value1")->nullable();
            $table->integer("value10")->nullable();
            $table->integer("value20")->nullable();
            $table->integer("value50")->nullable();
            $table->integer("carga1")->nullable();
            $table->integer("carga10")->nullable();
            $table->integer("carga20")->nullable();
            $table->integer("carga50")->nullable();
            $table->integer("total");
            $table->foreignId('user_id')
            ->constrained()
            ->cascadeOnDelete()
            ->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auxiliares');
    }
};

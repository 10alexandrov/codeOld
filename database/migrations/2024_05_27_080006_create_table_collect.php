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
        Schema::create('collects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('local_id')
                    ->references('id')
                    ->on('locals')
                    ->onDelete('cascade')
                    ->onUpdate('cascade'); // Definir la clave foránea
            $table->string('UserMoney');
            $table->string('LocationType');
            $table->string('MoneyType');
            $table->string('MoneyValue');
            $table->integer('Quantity');
            $table->double('Amount');
            $table->char('State', 1)->default('A');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collects');
    }
};

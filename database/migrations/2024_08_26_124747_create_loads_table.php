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
        Schema::create('loads', function (Blueprint $table) {
            $table->id();
            $table->integer('Number');
            $table->double('Quantity');
            $table->foreignId('Created_for')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('Closed_for')->nullable()->constrained('users')->onDelete('set null');
            $table->double('Partial_quantity')->nullable();
            $table->boolean('Irrecoverable')->default(false);
            $table->boolean('Initial')->default(false);
            $table->string('State'); // OPEN RECEIVE CLOSE
            $table->foreignId('machine_id')->constrained('machines');
            $table->dateTime('date_recovered')->nullable();
            $table->timestamps(); // created_at cuando se creo y el updated_at cuanod cambia el stado
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loads');
    }
};

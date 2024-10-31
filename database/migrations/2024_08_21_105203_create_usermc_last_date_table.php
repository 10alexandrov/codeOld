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
        Schema::create('last_usermc_date', function (Blueprint $table) {
            $table->id();
            $table->foreignId('delegation_id')
                    ->references('id')
                    ->on('delegations')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            $table->dateTime('lastDate');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('last_usermc_date');
    }
};

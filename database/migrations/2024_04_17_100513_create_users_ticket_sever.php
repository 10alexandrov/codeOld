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
        Schema::create('users_ticket_server', function (Blueprint $table) {
            $table->id();
            $table->string('User', 45); // Campo User de tipo varchar(45)
            $table->string('Name', 45)->nullable(); // Campo Name de tipo varchar(45)
            $table->string('Password'); // Campo Password de tipo varchar(45)
            //$table->foreignId('local_id')->constrained()->onDelete('cascade')->onUpdate('cascade'); // Definir la clave foránea
            $table->string('Rights', 1024); // Campo Rights de tipo varchar(1024)
            $table->tinyInteger('IsRoot')->default(0); // Campo IsRoot de tipo tinyint(1) con valor por defecto 0
            $table->tinyInteger('RightsCanBeModified')->default(1); // Campo RightsCanBeModified de tipo tinyint(1) con valor por defecto 1
            $table->decimal('CurrentBalance', 10, 2)->default(0.00); // Campo CurrentBalance de tipo decimal(10,2) con valor por defecto 0.00
            $table->decimal('ReloadBalance', 10, 2)->default(0.00); // Campo ReloadBalance de tipo decimal(10,2) con valor por defecto 0.00
            $table->integer('ReloadEveryXMinutes')->default(0); // Campo ReloadEveryXMinutes de tipo int(10) con valor por defecto 0
            $table->timestamp('LastReloadDate')->default('0001-01-01 00:00:00'); // Campo LastReloadDate de tipo timestamp con valor por defecto '0000-00-00 00:00:00'
            $table->tinyInteger('ResetBalance')->default(0); // Campo ResetBalance de tipo tinyint(1) con valor por defecto 0
            $table->integer('ResetAtHour')->default(0); // Campo ResetAtHour de tipo int(10) con valor por defecto 0
            $table->timestamp('LastResetDate')->default('0001-01-01 00:00:00'); // Campo LastResetDate de tipo timestamp con valor por defecto '0000-00-00 00:00:00'
            $table->decimal('MaxBalance', 10, 2)->default(0.00); // Campo MaxBalance de tipo decimal(10,2) con valor por defecto 0.00
            $table->string('TicketTypesAllowed', 1024)->default(''); // Campo TicketTypesAllowed de tipo varchar(1024) con valor por defecto ''
            $table->string('PID')->default(''); // Campo PID de tipo varchar(128) con valor por defecto ''
            $table->string('NickName', 64)->default(''); // Campo NickName de tipo varchar(64) con valor por defecto ''
            $table->string('Avatar', 1024)->default(''); // Campo Avatar de tipo varchar(1024) con valor por defecto ''
            $table->string('PIN', 8)->default('1234'); // Campo PIN de tipo varchar(8) con valor por defecto '1234'
            $table->integer('SessionType')->default(0); // Campo SessionType de tipo int(10) con valor por defecto 0
            $table->string('AdditionalOptionsAllowed', 1024)->default(''); // Campo AdditionalOptionsAllowed de tipo varchar(1024) con valor por defecto ''
            $table->string('rol')->default('');

            $table->timestamps(); // Campos created_at y updated_at
            //$table->unique('User'); // Clave única para el campo User
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_ticket_sever');
    }
};

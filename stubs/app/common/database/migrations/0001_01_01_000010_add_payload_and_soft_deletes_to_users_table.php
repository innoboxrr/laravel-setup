<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
 * Lo que el usuario generado por LaraPack necesita y la tabla `users` de Laravel
 * no trae: la copia de sus metas en `payload` y el borrado lógico.
 *
 * Va justo después de la migración de Laravel que crea la tabla. LaraPack no la
 * altera por su cuenta porque esa migración no la escribió él.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->longText('payload')->nullable()->after('password');
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropColumn('payload');
        });
    }
};

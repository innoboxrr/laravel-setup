<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tracking_events', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique(); // UUID del evento
            $table->string('event_name');       // Nombre del evento
            $table->string('utm_source')->nullable();
            $table->string('utm_medium')->nullable();
            $table->string('utm_campaign')->nullable();
            $table->string('utm_term')->nullable();
            $table->string('utm_content')->nullable();
            $table->string('gclid')->nullable();
            $table->string('fbclid')->nullable();
            $table->string('ttclid')->nullable();
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->json('geo')->nullable(); // Puede usarse para almacenar la ubicación geográfica
            $table->json('platforms')->nullable(); // Puede usarse para almacenar la información del dispositivo
            $table->json('event_data')->nullable(); // Datos adicionales del evento
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade'); // ID del usuario, si aplica
            $table->foreignId('cart_id')->nullable()->constrained()->onDelete('cascade'); // ID del carrito, si aplica
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tracking_events');
    }
};

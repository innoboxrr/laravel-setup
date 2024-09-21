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
        Schema::create('searches', function (Blueprint $table) {
            $table->id();
            $table->string('term');
            $table->text('image')->nullable();
            $table->text('description')->nullable();
            $table->string('link')->nullable();
            $table->string('locale')->nullable();
            $table->json('other')->nullable();
            $table->morphs('searchable');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['searchable_id', 'searchable_type']);
            $table->index('locale');
            $table->fullText(['term', 'description']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('searches');
    }
};

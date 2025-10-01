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
        
        Schema::create('abouts', function (Blueprint $table) {
            $table->id('id_about');
            $table->unsignedBigInteger('id_language')->nullable();
            $table->longText('about_1')->nullable();
            $table->longText('about_2')->nullable();
            $table->timestamps(); // created_at & updated_at otomatis
            $table->foreign('id_language')
                    ->references('id_language')->on('languages')
                    ->onUpdate('CASCADE')
                    ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('abouts');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // Tambahin ini

return new class extends Migration {
    public function up()
    {
        Schema::create('banner_details', function (Blueprint $table) {
            $table->id('id_banner_detail'); // AUTO_INCREMENT
            $table->unsignedBigInteger('id_banner')->nullable();
            $table->unsignedBigInteger('id_language')->nullable();
            $table->text('description')->nullable();
            $table->text('name_button', 199)->nullable();
            $table->text('name_link', 200)->nullable();
            $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->foreign('id_banner')
                    ->references('id_banner')->on('banners')
                    ->onUpdate('CASCADE')
                    ->onDelete('CASCADE');
            $table->foreign('id_language')
                    ->references('id_language')->on('languages')
                    ->onUpdate('CASCADE')
                    ->onDelete('CASCADE');
        });
    }

    public function down()
    {
        Schema::dropIfExists('banner_details');
    }
};

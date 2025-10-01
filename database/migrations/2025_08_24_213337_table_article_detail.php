<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // Tambahin ini

return new class extends Migration {
    public function up()
    {
        Schema::create('article_details', function (Blueprint $table) {
            $table->id('id_article_detail'); // AUTO_INCREMENT
            $table->unsignedBigInteger('id_article')->nullable();
            $table->unsignedBigInteger('id_language')->nullable();
            $table->text('title')->nullable();
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->foreign('id_article')
                    ->references('id_article')->on('articles')
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
        Schema::dropIfExists('article_details');
    }
};

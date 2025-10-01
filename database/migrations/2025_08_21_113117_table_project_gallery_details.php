<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // Tambahin ini

return new class extends Migration {
    public function up()
    {
        Schema::create('project_gallery_details', function (Blueprint $table) {
            $table->id('id_project_gallery_detail'); // AUTO_INCREMENT
            $table->unsignedBigInteger('id_project_gallery')->nullable();
            $table->unsignedBigInteger('id_language')->nullable();
            $table->string('name')->nullable();
            $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->foreign('id_project_gallery')
                    ->references('id_project_gallery')->on('project_galleries')
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
        Schema::dropIfExists('project_gallery_details');
    }
};

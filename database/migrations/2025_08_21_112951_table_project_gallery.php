<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // Tambahin ini

return new class extends Migration {
    public function up()
    {
        Schema::create('project_galleries', function (Blueprint $table) {
            $table->id('id_project_gallery'); // AUTO_INCREMENT
            $table->unsignedBigInteger('id_project')->nullable();
            $table->string('image',200)->nullable();
            $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->foreign('id_project')
                    ->references('id_project')->on('projects')
                    ->onUpdate('CASCADE')
                    ->onDelete('CASCADE');
        });
    }

    public function down()
    {
        Schema::dropIfExists('facility_details');
    }
};

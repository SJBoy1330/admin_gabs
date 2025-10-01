<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // Tambahin ini

return new class extends Migration {
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id('id_project'); // AUTO_INCREMENT
            $table->string('image', 199)->nullable();
            $table->string('name', 199)->nullable();
            $table->unsignedBigInteger('id_type')->nullable();
            $table->unsignedBigInteger('id_unit')->nullable();
            $table->unsignedBigInteger('id_location')->nullable();
             $table->integer('stock')->nullable();
            $table->double('price')->nullable();
            $table->text('address')->nullable();
            $table->string('lat', 199)->nullable();
            $table->string('lng', 199)->nullable();
            $table->enum('status', ['Y', 'N'])->default('Y');
            $table->text('reason')->nullable();
            $table->dateTime('blocked_date')->nullable();
            $table->unsignedBigInteger('blocked_by')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->foreign('created_by')
                    ->references('id_user')->on('users')
                    ->onUpdate('CASCADE')
                    ->onDelete('SET NULL');
            $table->foreign('id_location')
                    ->references('id_location')->on('locations')
                    ->onUpdate('CASCADE')
                    ->onDelete('SET NULL');
            $table->foreign('id_unit')
                    ->references('id_unit')->on('units')
                    ->onUpdate('CASCADE')
                    ->onDelete('SET NULL');
            $table->foreign('id_type')
                    ->references('id_type')->on('types')
                    ->onUpdate('CASCADE')
                    ->onDelete('SET NULL');
            $table->foreign('blocked_by')
                    ->references('id_user')->on('users')
                    ->onUpdate('CASCADE')
                    ->onDelete('SET NULL');
        });
    }

    public function down()
    {
        Schema::dropIfExists('projects');
    }
};

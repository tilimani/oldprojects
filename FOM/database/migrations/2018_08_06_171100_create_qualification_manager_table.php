<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQualificationManagerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qualification_managers', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('clean');
            $table->tinyInteger('communication');
            $table->tinyInteger('rules');
            $table->text('public_comment');
            $table->text('private_comment')->nullable();
            $table->text('fom_comment')->nullable();
            $table->tinyInteger('recommend');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('qualification_managers');
    }
}

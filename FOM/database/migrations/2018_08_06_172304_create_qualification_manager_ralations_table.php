<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQualificationManagerRalationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('qualification_managers', function (Blueprint $table) {
          $table->integer('bookings_id')->unsigned();
          $table->foreign('bookings_id')->references('id')->on('bookings')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('qualification_managers',function(blueprint $table){
          $table->dropForeign('qualification_managers_bookings_id_foreign');
          $table->dropColumn('bookings_id');
      });
    }
}

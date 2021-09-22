<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuggestedVisitingTimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suggested_visiting_times', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->date('visiting_date');
            $table->integer('visiting_time_from');
            $table->integer('visiting_time_to');
            $table->integer('status')->default(0);
        });

        Schema::table('suggested_visiting_times',function (Blueprint $table) {
            $table->integer('booking_id')->unsigned();
            $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('suggested_visiting_times',function (blueprint $table){
            $table->dropForeign('suggested_visiting_times_booking_id_foreign');
            $table->dropColumn('booking_id');
        });
        Schema::dropIfExists('suggested_visiting_times');
    }
}

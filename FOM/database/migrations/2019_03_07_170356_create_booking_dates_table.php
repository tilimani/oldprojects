<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingDatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_dates', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->date('user_date');
            $table->date('manager_date');
            $table->date('vico_date');
            $table->boolean('validation');
        });

        Schema::table('booking_dates', function (Blueprint $table) {
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
        Schema::table('booking_dates', function (Blueprint $table) {
            $table->dropForeign('booking_dates_booking_id_foreign');
            $table->dropColumn('booking_id');
        });

        Schema::dropIfExists('booking_dates');
    }
}

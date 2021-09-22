<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIconModeMessageNotes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->tinyInteger('mode')->nullable();
            $table->string('message', 767)->nullable();
        });

        Schema::table('rules', function (Blueprint $table) {
            $table->integer('icon')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn('mode');
            $table->dropColumn('message');
        });

        Schema::table('rules', function (Blueprint $table) {
            $table->dropColumn('icon');
        });
    }
}

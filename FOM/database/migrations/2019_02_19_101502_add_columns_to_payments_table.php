<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->string('cuota', 5)->default('1/1');
            $table->string('transaction_id', 128)->nullable();
            $table->string('metadata', 512);
            $table->smallInteger('type')->insigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn('cuota');
            $table->dropColumn('transaction_id');
            $table->dropColumn('metadata');
            $table->dropColumn('type');
        });
    }
}

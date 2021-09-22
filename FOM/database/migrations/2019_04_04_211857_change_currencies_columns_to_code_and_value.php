<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeCurrenciesColumnsToCodeAndValue extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('currencies', function (Blueprint $table) {
            $table->dropColumn('eur_cop');
            $table->dropColumn('usd_cop');
            $table->string('code',3);            
            $table->float('value',11,10);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('currencies', function (Blueprint $table) {            
            $table->float('eur_cop', 9, 9);
            $table->float('usd_cop', 9, 9);
            $table->dropColumn('code');
            $table->dropColumn('value');
        });
    }
}

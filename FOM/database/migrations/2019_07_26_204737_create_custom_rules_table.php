<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custom_rules', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('description',767);
        });
        Schema::table('custom_rules', function (Blueprint $table) {
            $table->integer('house_id')->unsigned();
            $table->foreign('house_id')->references('id')->on('houses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
        Schema::table('custom_rules',function (blueprint $table){
            $table->dropForeign('custom_rules_house_id_foreign');
            $table->dropColumn('house_id');
        });

        Schema::dropIfExists('custom_rules');
    }
}

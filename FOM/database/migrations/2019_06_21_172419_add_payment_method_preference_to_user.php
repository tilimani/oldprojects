<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPaymentMethodPreferenceToUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('preferred_payment_method')->unsigned();
        });

        DB::table('payment_types')->insert([
            'description'=>'cash'
        ]);

        DB::table('data_payments')->insert([
            'user_id' => 1,
            'customer_id' => 'manual_payment_user_1',
            'source_id' => 'manual_payment_user_1',
            'full_name' => 'VICO en el data payments',
            'document_type' => 'passport',
            'document' => encrypt('Polas'),
            'address' => encrypt('La combi completa'),
            'city' => encrypt('Una cosita!'),
            'zipcode' => encrypt('Chimbitas'),
            'country' => encrypt('Toco madera')
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('preferred_payment_method');
        });

        DB::table('payment_types')->where('description', 'cash')->delete();
        DB::table('data_payments')->where('user_id', 1)->where('customer_id','manual_payment_user_1')->delete();
    }
}

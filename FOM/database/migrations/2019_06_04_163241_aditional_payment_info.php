<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AditionalPaymentInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payments', function (Blueprint $table) {

            $table->string('payment_method');  
            $table->string('current_account');
           
            $table->decimal('discount_cop', 9, 2);
            $table->decimal('discount_eur', 5, 2);

            $table->decimal('room_price_cop', 9, 2);
            $table->decimal('room_price_eur', 5, 2);

            $table->decimal('vico_comision_cop', 9, 2);
            $table->decimal('vico_comision_eur', 5, 2);

            $table->decimal('vico_transaction_fee_cop', 9, 2);
            $table->decimal('vico_transaction_fee_eur', 5, 2);

            $table->decimal('stripe_fee_cop', 9, 2);
            $table->decimal('stripe_fee_eur', 5, 2);
            
            $table->decimal('payout_amount', 9, 2);
            $table->decimal('payout_fee', 9, 2);
            $table->smallInteger('payout_batch');

            $table->string('payment_proof');
            $table->string('additional_info');

        });

        DB::table('data_payments')->insert([
            'user_id' => 1,
            'customer_id' => 'manual_payment_vico_1',
            'source_id' => 'manual_payment_vico_1',
            'full_name' => 'VICO en el data payments',
            'document_type' => 'passport',
            'document' => encrypt('Polas'),
            'address' => encrypt('La combi completa'),
            'city' => encrypt('Una cosita!'),
            'zipcode' => encrypt('Chimbitas'),
            'country' => encrypt('Toco madera')
        ]);

        DB::table('data_payments')->insert([
            'user_id' => 1,
            'customer_id' => 'manual_payment_manager_1',
            'source_id' => 'manual_payment_manager_1',
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
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn('discount_cop');
            $table->dropColumn('discount_eur');

            $table->dropColumn('room_price_cop');
            $table->dropColumn('room_price_eur');

            $table->dropColumn('vico_comision_cop');
            $table->dropColumn('vico_comision_eur');

            $table->dropColumn('stripe_fee_cop');
            $table->dropColumn('stripe_fee_eur');

            $table->dropColumn('payment_method');   
            
            $table->dropColumn('vico_transaction_fee_cop');
            $table->dropColumn('vico_transaction_fee_eur');
            $table->dropColumn('current_account');
            $table->dropColumn('payment_proof');
            $table->dropColumn('payout_amount');
            $table->dropColumn('payout_fee');
            $table->dropColumn('additional_info');
            $table->dropColumn('payout_batch');

        });

        DB::table('data_payments')->where('user_id', 1)->where('customer_id','manual_payment_vico_1')->delete();
        DB::table('data_payments')->where('user_id', 1)->where('customer_id','manual_payment_manager_1')->delete();
    }
}

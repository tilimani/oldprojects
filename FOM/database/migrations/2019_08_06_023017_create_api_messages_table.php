<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApiMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('api_messages', function (Blueprint $table) {
            $table->increments('id');
            // $table->string('sms_message_sid', 100);
            // $table->string('sms_sid', 100);
            // $table->string('message_sid', 100);
            // $table->string('account_sid', 100);
            $table->smallInteger('num_media');
            // $table->string('sms_status', 25);
            $table->longText('body')->nullable();
            $table->string('to', 25);
            $table->string('from', 25);
            $table->string('api_version', 15);
            $table->smallInteger('num_segments');
            $table->string('media_content_type')->nullable();
            $table->string('media_url')->nullable();
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
        Schema::dropIfExists('api_messages');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTradingMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trading_messages', function (Blueprint $table) {
            $table->id();
            $table->text('customer_msg');
            $table->bigInteger('user_id')->unsigned();
            $table->integer('user_id_sent');
            $table->integer('user_id_receive');

            $table->foreign('user_id')
            ->references('id')
            ->on('users')
            ->onDelete('cascade');  

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
        Schema::dropIfExists('trading_messages');
    }
}

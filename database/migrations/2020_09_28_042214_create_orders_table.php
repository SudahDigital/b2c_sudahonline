<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->Biginteger('user_id')->unsigned();
            //$table->string('session_id')->nullable();
            $table->BigInteger('customer_id')->unsigned()->nullable();
            //$table->string('username')->nullable();
            //$table->string('email')->nullable();
            //$table->text('address')->nullable();
            $table->string('phone')->nullable();
            $table->float('total_price')->unsigned()->default(0);
            $table->string('invoice_number');
            $table->enum('status', ['SUBMIT', 'PROCESS', 'FINISH','CANCEL']);
            $table->timestamps();
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function(Blueprint $table){
            $table->dropForeign('orders_session_id_foreign');
            });
        Schema::dropIfExists('orders');
    }
}

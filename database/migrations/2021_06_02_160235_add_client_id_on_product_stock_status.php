<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddClientIdOnProductStockStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_stock_status', function (Blueprint $table) {
            $table->integer('client_id')->unsigned()->nullable()->after('stock_status');
            
            //$table->foreign('client_id')->references('id')->on('b2b_client');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_stock_status', function (Blueprint $table) {
            $table->dropColumn('client_id');
        });
    }
}

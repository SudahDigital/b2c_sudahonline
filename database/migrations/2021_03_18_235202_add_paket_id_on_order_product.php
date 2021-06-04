<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaketIdOnOrderProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_product', function($table) {
            $table->integer('paket_id')->unsigned()->nullable();
            
            $table->foreign('paket_id')->references('id')->on('pakets');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_product', function($table) {
            $table->dropColumn('paket_id');
        });
    }
}

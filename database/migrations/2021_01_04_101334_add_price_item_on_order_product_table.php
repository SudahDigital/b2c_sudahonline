<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPriceItemOnOrderProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_product', function($table) {
            $table->float('price_item')->nullable()->after('product_id');
            $table->float('price_item_promo')->nullable()->after('price_item');
            $table->float('discount_item')->nullable()->after('price_item_promo');
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
            $table->dropColumn('price_item');
            $table->dropColumn('price_item_promo');
            $table->dropColumn('discount_item');
        });
    }
}

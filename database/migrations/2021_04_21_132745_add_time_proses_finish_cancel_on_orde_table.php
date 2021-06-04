<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTimeProsesFinishCancelOnOrdeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function($table) {
            $table->timestamp('process_time')->nullable();
            $table->timestamp('finish_time')->nullable();
            $table->timestamp('cancel_time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function($table) {
            $table->dropColumn('process_time');
            $table->dropColumn('finish_time');
            $table->dropColumn('cancel_time');
        });
    }
}

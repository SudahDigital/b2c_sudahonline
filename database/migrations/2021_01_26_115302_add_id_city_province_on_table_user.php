<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdCityProvinceOnTableUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function($table) {
            $table->integer('city_id')->nullable()->after('address');
            //$table->integer('province_id')->nullable('city_id');
            $table->text('profile_desc')->nullable()->after('city_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function($table) {
            $table->dropColumn('city_id');
            //$table->dropColumn('province_id');
            $table->text('profile_desc');
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupsPaketTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups_paket', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('group_id')->unsigned()->nullable();
            $table->integer('paket_id')->unsigned()->nullable();
            $table->enum('status',['ACTIVE','INACTIVE']);
            $table->timestamps();

            $table->foreign('group_id')->references('id')->on('groups');
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
        Schema::dropIfExists('groups_paket');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->bigIncrements( 'id' )->unsigned();
            $table->string( 'code' )->nullable( );
            $table->string( 'name' );
            $table->text( 'description' )->nullable();
            $table->integer( 'uses' )->unsigned()->nullable();
            $table->integer( 'max_uses' )->unsigned()->nullable();
            // How many times a user can use this voucher.
            //$table->integer( 'max_uses_user' )->unsigned( )->nullable( );
            // The type can be: voucher, discount, sale. What ever you want.
            $table->tinyInteger( 'type' )->unsigned();
            $table->float( 'discount_amount' );
            // Whether or not the voucher is a percentage or a fixed price. 
            //$table->boolean( 'is_fixed' )->default( true );
            $table->timestamp( 'starts_at' )->nullable();
            $table->timestamp( 'expires_at' )->nullable();
            //$table->enum('status', ['ACTIVE', 'EXPIRED','DEACTIVATED']);
            $table->string( 'status' )->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vouchers');
    }
}

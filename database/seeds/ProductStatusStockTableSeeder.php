<?php

use Illuminate\Database\Seeder;

class ProductStatusStockTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $stock_status =[
            [
            'status_name' => 'Product Stock',
            ]
        ]; 
        
        DB::table('product_stock_status')->insert($stock_status);
    }
}

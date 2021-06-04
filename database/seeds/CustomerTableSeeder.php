<?php

use Illuminate\Database\Seeder;

class CustomerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
        $customer =[
            [
            'name' => 'Jhon',
            'email' => 'Jhon@email.com',
            'phone' => 123456789986,
            'store_name' => 'Jhon Store',
            'address'=>'Jl. Merdeka, Jakarta-Barat'
            ],
            [
            'name' => 'Robert',
            'email' => 'robert@email.com',
            'phone' => 123456789987,
            'store_name' => 'Robert Store',
            'address'=>'Jl. Merah Putih, Jakarta-Utara'
            ],
            [
            'name' => 'Abraham',
            'email' => 'abraham@email.com',
            'phone' => 123456789988,
            'store_name' => 'Abraham Store',
            'address'=>'Jl. Kalimaya, Jakarta-Selatan'
            ]
        ]; 
        
        DB::table('customers')->insert($customer);    
        
    }
}

<?php

use Illuminate\Database\Seeder;

class ClientTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dateNow = date('Y-m-d H:i:s');
        $client=[
            [
                'client_name'=>'Mega Cool',
                'client_slug'=>\Str::slug('Mega Cool','-'),
                'company_name'=>'CV. Mega Cool',
                'client_address'=>'Jakarta Barat',
                'created_at'=>$dateNow,
                'updated_at'=>$dateNow
            ],
            [
                'client_name'=>'Mega Hot',
                'client_slug'=>\Str::slug('Mega Hot','-'),
                'company_name'=>'CV. Mega Bad',
                'client_address'=>'Jakarta Barat',
                'created_at'=>$dateNow,
                'updated_at'=>$dateNow
            ]
        ];

         
        DB::table('b2b_client')->insert($client);
    }
}

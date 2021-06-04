<?php

use Illuminate\Database\Seeder;

class AdminstratorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $administrator = new App\User;
        $administrator -> username ='Administrator';
        $administrator -> name ='Site Administrator';
        $administrator -> email ='administrator@larashop.test';
        $administrator -> roles =json_encode(['ADMIN']);
        $administrator -> password = \Hash::make('larashop');
        $administrator -> avatar = 'Saat-ini-tidak-ada-file.png';
        $administrator -> address = 'Zuki, Batara, Kab. Tangerang';

        $administrator -> save();
        $this->command->info('User Admin Berhasil Diinsert');
    }
}

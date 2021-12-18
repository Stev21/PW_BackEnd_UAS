<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Stev',
            'email' => 'hostsupermarket21@gmail.com',
            'password' => '$2b$10$ge1zpfDpZopVqiPCjawAPugi431GCuyLcv.nOMJXVEjsRveiC7vue',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}

<?php

use Illuminate\Database\Seeder;

class InitialUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory('App\User')
        ->create(['username' => 'hossein.nas', 'email'=> 'hossein@example.com', 'password' => bcrypt('123') ]);
        factory('App\User')
        ->create(['username' => 'admin', 'email'=> 'admin@example.com', 'password' => bcrypt('admin') ]);
    }
}

<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(InitialFilesSeeder::class);
        $this->call(InitialColorsSeeder::class);
        $this->call(InitialRolesSeeder::class);
        $this->call(InitialPermissionsSeeder::class);
        $this->call(InitialUserSeeder::class);
    }
}

<?php

use Illuminate\Database\Seeder;

class InitialPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $post = [
            [
                'title' => 'این اولین پست وب‌سایت می‌باشد.',
                'slug' => 'first_post',
                'content' => 'lLorem ipsum dolor, sit amet consectetur adipisicing elit. Magni modi asperiores ipsam architecto. Impedit, quae',
            ],
            [
                'title' => 'یک پست نمونه ارسالی',
                'slug' => 'second_post',
                'content' => 'lLorem ipsum dolor, sit amet consectetur adipisicing elit. Magni modi asperiores ipsam architecto. Impedit, quae',
            ]
        ];
        foreach( $post as $p ){
            factory('App\Post')->create($p);
        }

    }
}

<?php

use Illuminate\Database\Seeder;

class InitialCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cats = [
            [ 'title' => 'برنامه نویسی' ],
            [ 'title' => 'شبکه‌های' ],
            [ 'title' => 'شبکه' ],

            [ 'title' => 'PHP', 'parent_id' => 1 ],
            [ 'title' => 'PYTHON', 'parent_id' => 1 ],
            [ 'title' => 'Javascript', 'parent_id' => 1 ],
            [ 'title' => 'HTML and CSS', 'parent_id' => 1 ],

            [ 'title' => 'اینستاگرام', 'parent_id' => 2 ],
            [ 'title' => 'تلگرام', 'parent_id' => 2 ],
            [ 'title' => 'توئیتر', 'parent_id' => 2 ],
        ];

        foreach( $cats as $cat ){
            factory('App\Category')->create($cat);
        }
    }
}

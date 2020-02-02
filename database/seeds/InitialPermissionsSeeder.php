<?php

use Illuminate\Database\Seeder;

class InitialPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'title'             => 'ادمین',
                'desc'              => 'ادمین سایت توانایی هرکاری دارد.',
                'slug'              => 'Admin',
            ],
            [
                'title'             => 'مدیر',
                'desc'              => 'به مانند مدیر می‌باشد و توانایی مدیریت تمامی بخش‌های وب‌سایت را دارد.',
                'slug'              => 'Manager',
            ],
            [
                'title'             => 'نویسنده',
                'desc'              => 'نویسنده‌ی وبسایت می‌باشد و مدیریت بر اخبار و مقالات را به عهده دارد.',
                'slug'              => 'Writer',
            ],
        ];

        foreach( $roles as $role){
            factory('App\Role')->create($role);
        }
    }
}

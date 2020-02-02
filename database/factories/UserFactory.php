<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\User;
use App\File;
use App\Permission;
use App\Role;
use Illuminate\Support\Str;
use Faker\Generator as Faker;
use Faker\Factory as _Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'firstname' => $faker->name,
        'lastname' => $faker->name,
        'username' => $faker->name,
        'gender' => 'male',
        'activated' => 1,
        'role_id' => 1,
        'thumbnail_id' => 1,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
    ];
});


$factory->define(File::class, function(Faker $faker){
    return [
        'Title'     => $faker->text,
        'name'      => $faker->file('/','../', false),
        'desc'      => $faker->text,
        'hashname'  => $faker->text,
        'ext'       => $faker->text,
        'basedir'   => $faker->text,
        'base_url'  => $faker->text,
        'is_responsive' => 1,
        'keywords'  => "system_pics,avatar",
        'specs'      => "{}",
    ];
});

$factory->define(Role::class, function(Faker $faker){
    return [
        'title' => $faker->word,
        'desc'  => $faker->text,
        'slug' => $faker->word,
    ];
});

$factory->define(Permission::class, function(Faker $faker){
    return [
        'title' => $faker->word,
        'desc'  => $faker->text,
        'slug' => $faker->word,
    ];
});
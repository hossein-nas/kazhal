<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\File;
use App\Post;
use App\Role;
use App\User;
use App\Comment;
use App\Category;
use App\Permission;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

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
        'firstname'         => $faker->name,
        'lastname'          => $faker->name,
        'username'          => $faker->name,
        'gender'            => 'male',
        'activated'         => true,
        'role_id'           => 1,
        'thumbnail_id'      => 1,
        'email'             => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password'          => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token'    => Str::random(10),
    ];
});

$factory->define(File::class, function (Faker $faker) {
    return [
        'title'         => $faker->word,
        'name'          => str_slug($faker->sentence(3), '_') . '.png',
        'desc'          => $faker->text,
        'hashname'      => \Illuminate\Support\Str::uuid()->toString(),
        'ext'           => 'png',
        'basedir'       => $faker->text,
        'base_url'      => $faker->text,
        'is_responsive' => 1,
        'keywords'      => "system_pics,avatar",
        'specs'         => "{}",
    ];
});

$factory->define(Post::class, function (Faker $faker) {
    $title = $faker->sentence(3);

    return [
        'title'        => $title,
        'content'      => $faker->text,
        'slug'         => str_slug($title),
        'published'    => 0,
        'user_id'      => function () {
            return auth()->check() ? auth()->id() : factory('App\User')->create()->id;
        },
        'thumbnail_id' => function () {
            return factory('App\File')->create()->id;
        },
        'post_type'    => 1,
    ];
});

$factory->define(Role::class, function (Faker $faker) {
    return [
        'title' => $faker->word,
        'desc'  => $faker->text,
        'slug'  => $faker->word,
    ];
});

$factory->define(Permission::class, function (Faker $faker) {
    return [
        'title' => $faker->word,
        'desc'  => $faker->text,
        'slug'  => $faker->word,
    ];
});

$factory->define(Category::class, function (Faker $faker) {
    return [
        'title'     => $faker->word,
        'parent_id' => null,
    ];
});

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'name'      => $faker->name,
        'body'      => $faker->text,
        'email'     => $faker->unique()->safeEmail,
        'post_id'   => function () {
            return factory(Post::class)->create()->id;
        },
        'parent_id' => null,
        'verified'  => 1,
    ];
});

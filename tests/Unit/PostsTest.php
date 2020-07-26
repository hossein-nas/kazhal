<?php

namespace Tests\Unit;

use App\Category;
use App\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function thumbnail_is_appended_to_post()
    {
        $post = factory(Post::class)->create();

        tap($post->fresh()->toArray(), function ($post) {
            $this->assertTrue(array_key_exists('thumb', $post));
        });
    }

    /** @test */
    public function author_is_appended_to_post()
    {
        $post = factory(Post::class)->create();

        tap($post->fresh()->toArray(), function ($post) {
            $this->assertTrue(array_key_exists('author', $post));
        });
    }

    /** @test */
    public function categories_are_appended_to_post()
    {
        $post = factory(Post::class)->create();

        tap($post->fresh()->toArray(), function ($post) {
            $this->assertTrue(array_key_exists('author', $post));
        });
    }

    /** @test */
    public function a_authorized_user_can_post_new_post()
    {
        $post = factory(Post::class)->raw();

        $post['categories'] = [
            factory(Category::class)->create()->id,
            factory(Category::class)->create()->id,
        ];

        $response = $this->json('post', route('posts.store'), $post);
    }
}

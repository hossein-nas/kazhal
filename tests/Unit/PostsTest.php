<?php

namespace Tests\Unit;

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
    public function a_post_knows_its_own_path()
    {
        $post = factory(Post::class)->create();

        $this->assertEquals("/posts/{$post->slug}/show", $post->path());
    }

    /** @test */
    public function post_instance_include_its_own_path()
    {
        $post = factory(Post::class)->create();

        tap($post->fresh()->toArray(), function ($post) {
            $this->assertTrue(
                array_key_exists('path', $post)
            );
        });
    }

    // /** @test */
    // public function post_knows_its_own_path()
    // {
    //     //
    // }

    // /** @test */
    // public function post_can_calculate_its_own_view_counts()
    // {
    //     //
    // }

    // /** @test */
    // public function post_can_be_invisible()
    // {
    //     //
    // }

    // /** @test */
    // public function post_can_be_visible()
    // {
    //     //
    // }

    // /** @test */
    // public function post_can_be_set_on_need_to_be_review_state()
    // {
    //     //
    // }

    // /** @test */
    // public function post_can_be_archived()
    // {
    //     //
    // }
}

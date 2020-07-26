<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreatePostTest extends TestCase
{
    use RefreshDatabase;
    public function setup()
    {
        parent::setUp();

        //
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

    /** @test */
    public function posts_also_may_be_able_to_update_by_superadmin()
    {
        //
    }

    /** @test */
    public function posts_may_be_able_to_update_by_post_owner()
    {
        //
    }

    /** @test */
    public function posts_visibility_can_be_changed_by_admin()
    {
        //
    }

    /** @test */
    public function posts_which_is_created_by_basic_writer_by_default_is_in_need_to_review_state()
    {
        //
    }

    /** @test */
    public function unauthorized_user_may_not_be_able_to_post()
    {
        //
    }
}

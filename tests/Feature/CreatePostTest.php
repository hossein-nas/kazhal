<?php

namespace Tests\Feature;

use App\Post;
use App\Category;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreatePostTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var mixed
     */
    protected $post = null;

    public function setup(): void
    {
        parent::setUp();

        //
    }

    /** @test */
    public function unauthorized_user_may_not_create_posts()
    {
        $post = factory(Post::class)->raw();

        $response = $this->json('post', route('posts.store'), $post);

        $response->assertRedirect('/login');
    }

    /** @test */
    public function a_authorized_user_can_post_new_post()
    {
        $this->createPost();

        $response = $this->json('post', route('posts.store'), $this->post);

        $response->assertStatus(200);
        $this->assertCount(1, Post::all());
    }

    /** @test */
    public function unvalid_thumbnail_id_produces_error()
    {
        $this->createPost(['thumbnail_id' => 999]);

        $response = $this->json('post', route('posts.store'), $this->post);

        tap($response->json(), function ($errors) use ($response) {
            $response->assertStatus(422);

            $this->assertCount(1, $errors['thumbnail_id']);
        });
    }

    /** @test */
    public function user_provided_categories_persisted_in_db()
    {
        $this->createPost();

        $response = $this->json('post', route('posts.store'), $this->post);

        $this->assertCount(2, Post::latest()->first()->categories);
    }

    /** @test */
    public function post_auther_can_deleted_post()
    {
        $this->createPost();

        $response = $this->json('post', route('posts.store'), $this->post);

        $this->assertCount(1, Post::all());

        tap($response->json()['data']['slug'], function ($post_slug) {
            $this->json('delete', route('posts.destroy', $post_slug));

            $this->assertCount(0, Post::all());
        });
    }

    // /** @test */
    // public function posts_also_may_be_able_to_update_by_superadmin()
    // {
    //     //
    // }

    // /** @test */
    // public function posts_may_be_able_to_update_by_post_owner()
    // {
    //     //
    // }

    // /** @test */
    // public function posts_visibility_can_be_changed_by_admin()
    // {
    //     //
    // }

    // /** @test */
    // public function posts_which_is_created_by_basic_writer_by_default_is_in_need_to_review_state()
    // {
    //     //
    // }

    // /** @test */
    // public function unauthorized_user_may_not_be_able_to_post()
    // {
    //     //
    // }

    /**
     * Description about :: createPost ::
     */
    public function createPost($overrides = [], $user = null)
    {
        $user = $user ?: factory('App\User')->create();

        $this->signIn($user);

        $post = factory(Post::class)->raw($overrides);

        $post['categories'] = [
            factory(Category::class)->create()->id,
            factory(Category::class)->create()->id,
        ];

        $this->post = $post;
    }
}

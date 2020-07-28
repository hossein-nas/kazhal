<?php

namespace Tests\Feature;

use App\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateCommentTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        //
    }

    /** @test */
    public function a_guest_can_send_reply()
    {
        $comment = factory(Comment::class)->raw();

        $response = $this->json('post', route('comment.store'), $comment);

        $response->assertStatus(201);
        $this->assertCount(1, Comment::all());
    }

    /** @test */
    public function comments_by_default_should_have_unverified_state()
    {
        $comment = factory(Comment::class)->raw();

        $response = $this->json('post', route('comment.store'), $comment);

        $this->assertFalse(!!Comment::latest()->first()->verified);
    }

    /** @test */
    public function unvalid_commenter_name_should_produce_error()
    {
        $comment = factory(Comment::class)->raw();
        $comment['name'] = 'Unvalid-Name';

        $response = $this->json('post', route('comment.store'), $comment);

        $response->assertStatus(422);
        $this->assertTrue(
            array_key_exists('name', $response->json())
        );
    }

    /** @test */
    public function unvalid_commenter_text_should_produce_error()
    {
        $comment = factory(Comment::class)->raw();
        $comment['body'] = 'Unvalid body for comment is like this : $';

        $response = $this->json('post', route('comment.store'), $comment);

        $response->assertStatus(422);
        $this->assertTrue(
            array_key_exists('body', $response->json())
        );
    }

    /** @test */
    public function unvalid_email_address_should_produce_error()
    {
        $comment = factory(Comment::class)->raw();
        $comment['email'] = 'example.com';

        $response = $this->json('post', route('comment.store'), $comment);

        $response->assertStatus(422);
        $this->assertTrue(
            array_key_exists('email', $response->json())
        );
    }

    /** @test */
    public function empty_email_address_should_not_produce_error()
    {
        $comment = factory(Comment::class)->raw();
        $comment['email'] = null;

        $response = $this->json('post', route('comment.store'), $comment);

        $response->assertStatus(201);
    }

    /** @test */
    public function post_should_be_available_in_comment_instance()
    {
        $comment = factory(Comment::class)->create();

        $response = $this->json('get', route('comment.show', $comment->id));

        $this->assertTrue(
            array_key_exists('post', $response->json())
        );
    }

    /** @test */
    public function comments_parent_should_be_available_in_comment_instance()
    {
        $comment = factory(Comment::class)->create();

        $response = $this->json('get', route('comment.show', $comment->id));

        $this->assertNull($response->json()['parent']);

        $commentOne = factory(Comment::class)->create();
        $commentTwo = factory(Comment::class)->create(['parent_id' => $commentOne->id]);

        $response = $this->json('get', route('comment.show', $commentTwo->id));

        $this->assertEquals($commentOne->id, $response->json()['parent']['id']);
    }
}

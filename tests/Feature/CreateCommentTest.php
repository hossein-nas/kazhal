<?php

namespace Tests\Feature;

use App\Comment;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

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

        $this->assertFalse(!! Comment::latest()->first()->verified);
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
}

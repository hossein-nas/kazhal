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

}

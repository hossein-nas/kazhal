<?php

namespace Tests\Unit;

use App\Comment;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function comment_knows_about_local_time()
    {
        $comment = factory(Comment::class)->create();

        $this->assertTrue(array_key_exists('local_time', $comment->toArray()));
    }
}

<?php

namespace Tests\Unit;

use App\User;
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

    /** @test */
    public function comments_can_be_approved()
    {
        $comment = factory(Comment::class)->create();

        $this->assertFalse( !  ! $comment->verified);

        $comment->verify();

        $this->assertTrue( !  ! $comment->fresh()->verified);
    }

    /** @test */
    public function comments_can_be_unapproved()
    {
        $comment = factory(Comment::class)->create(['verified' => 1]);

        $comment->unverify();

        $this->assertFalse( !  ! $comment->fresh()->verified);
    }

    /** @test */
    public function comments_created_by_user_is_accessable()
    {
        $this->signIn($user = factory(User::class)->create());

        $comment = factory(Comment::class, 2)->create(['user_id' => $user->id]);

        $this->assertCount(2, $user->fresh()->comments);
    }
}

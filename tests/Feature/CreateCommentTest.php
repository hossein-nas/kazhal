<?php

namespace Tests\Feature;

use App\User;
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
        $this->assertCount(1, Comment::withoutGlobalScopes()->get());
    }

    /** @test */
    public function comments_by_default_should_have_unverified_state()
    {
        $comment = factory(Comment::class)->raw();

        $response = $this->json('post', route('comment.store'), $comment);

        $this->assertFalse( !  ! Comment::withoutGlobalScopes()->latest()->first()->verified);
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
        $this->signIn();

        $comment = factory(Comment::class)->create();

        $response = $this->json('get', route('comment.show', $comment->id));

        $this->assertTrue(
            array_key_exists('post', $response->json())
        );
    }

    /** @test */
    public function comments_parent_should_be_available_in_comment_instance()
    {
        $this->signIn();

        $comment = factory(Comment::class)->states('verified')->create();

        $response = $this->json('get', route('comment.show', $comment->id));

        $this->assertNull($response->json()['parent']);

        $commentOne = factory(Comment::class)->states('verified')->create();
        $commentTwo = factory(Comment::class)->states('verified')->create(['parent_id' => $commentOne->id]);

        $response = $this->json('get', route('comment.show', $commentTwo->id));

        $this->assertEquals($commentOne->id, $response->json()['parent']['id']);
    }

    /** @test */
    public function a_user_can_approve_a_comment()
    {
        $this->signIn($user = factory(User::class)->create());

        $comment = factory(Comment::class)->create();

        $response = $this->json('POST', route('approve.comment', $comment->id));

        tap($comment->fresh(), function ($comment) use ($user) {
            $this->assertTrue( !  ! $comment->verified);
            $this->assertEquals($user->id, $comment->verified_by);
        });
    }

    /** @test */
    public function a_user_can_unapprove_a_comment()
    {
        $this->signIn($user = factory(User::class)->create());

        $comment = factory(Comment::class)->create(['verified' => 1, 'verified_by' => $user->id]);

        $response = $this->json('DELETE', route('unapprove.comment', $comment->id));

        tap($comment->fresh(), function ($comment) use ($user) {
            $this->assertFalse( !  ! $comment->verified);
            $this->assertEquals(null, $comment->verified_by);
        });
    }

    /** @test */
    public function a_user_can_fetch_all_unapproved_comments()
    {
        $this->signIn();

        $UnapprovedComments = factory(Comment::class, $unapprovedCount = 5)->create();
        $approvedComments = factory(Comment::class, 2)->create(['verified' => 1]);

        $response = $this->json('get', route('comments.index', ['unapproved' => 1]));

        $this->assertCount($unapprovedCount, $response->json());
    }

    /** @test */
    public function a_user_can_fetch_all_approved_comments()
    {
        $this->signIn();

        $UnapprovedComments = factory(Comment::class, 2)->create();
        $approvedComments = factory(Comment::class, $approvedCount = 4)->create(['verified' => 1]);

        $response = $this->json('get', route('comments.index'));

        $this->assertCount($approvedCount, $response->json());
    }

    /** @test */
    public function a_user_can_fetch_all_own_approved_comments()
    {
        $this->signIn();

        $approvedComments = factory(Comment::class, $approvedCount = 4)->create(['verified' => 1, 'verified_by' => $this->user->id]);
        $approvedComments = factory(Comment::class, 2)->create(['verified' => 1]);

        $response = $this->json('get', route('comments.index', ['own' => 1]));

        $this->assertCount($approvedCount, $response->json());
    }

    /** @test */
    public function a_user_can_reply_to_an_existing_comment()
    {
        $this->signIn();

        $comment = factory(Comment::class)->states('verified')->create();
        $adminReplyForComment = factory(Comment::class)
            ->raw(['parent_id' => $comment->id, 'post_id' => $comment->post_id]);

        $response = $this->json('POST',
            route('api.comment.store'),
            $adminReplyForComment
        );

        $response->assertStatus(201);

        $this->assertCount(1, $this->user->fresh()->comments);

        $this->assertEquals(
            $comment->fresh()->id,
            $this->user->fresh()->comments->first()->parent_id
        );

        $this->assertEquals(
            $this->user->id,
            $this->user->comments->last()->user_id
        );
    }
}

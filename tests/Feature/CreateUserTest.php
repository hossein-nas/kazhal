<?php

namespace Tests\Feature;

use App\File;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateUserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_change_its_thumbnail()
    {
        $imageOne = factory(File::class)->create();
        $imageTwo = factory(File::class)->create();

        $user = factory(User::class)->create(['thumbnail_id' => $imageOne->id]);
        $this->signIn($user);

        $this->assertEquals($user->thumbnail_id, $imageOne->id);

        $response = $this->json('PATCH', route('change-thumbnail', $this->user->id), ['thumbnail_id' => $imageTwo->id]);

        $this->assertEquals($user->fresh()->thumbnail_id, $imageTwo->id);
    }

    /** @test */
    public function unauthorized_request_to_changing_thumbnail_will_result_exception()
    {
        $this->withoutExceptionHandling();
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $response = $this->json('PATCH', route('change-thumbnail', 1), ['thumbnail_id' => 1]);
    }

    /** @test */
    public function wrong_data_will_produce_403()
    {
        $user = factory(User::class)->create();
        $this->signIn($user);

        $response = $this->json('PATCH', route('change-thumbnail', $this->user->id), []);

        $response->assertStatus(403);
    }
}

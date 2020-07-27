<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FileUploadTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('avatars');
    }

    /** @test */
    public function unauthorized_user_may_not_send_new_file()
    {
        $response = $this->json('POST', route('file-upload.store'), []);

        $response->assertRedirect('/login');
    }

    /** @test */
    public function after_successful_upload_original_file_is_removed()
    {
        // $this->withoutExceptionHandling();
        $this->signIn();

        $file = UploadedFile::fake()->image('avatar.png', 1500, 1000);

        $response = $this->json('POST', route('file-upload.store'), [
            'title' => 'New File',
            'desc'  => 'without desc',
            'name'  => 'new_file_13.jpeg',
            'file'  => $file,
        ]);

        tap($response->json()['data'], function ($data) {
            $filename = $data['hashname'] . '.' . $data['ext'];

            Storage::disk('avatars')->assertMissing('public/images/' . $filename);
        });
    }

    /** @test */
    public function user_can_upload_valid_image_to_server()
    {
        // $this->withoutExceptionHandling();
        $this->signIn();

        $file = UploadedFile::fake()->image('avatar.png', 1500, 1000);

        $response = $this->json('POST', route('file-upload.store'), [
            'title' => 'New File',
            'desc'  => 'without desc',
            'name'  => 'new_file_13.jpeg',
            'file'  => $file,
        ]);

        $this->assertEquals('New File', \App\File::latest()->first()->title);
    }

    /** @test */
    public function image_requires_valid_title_to_be_uploaded()
    {
        $this->signIn();

        $file = UploadedFile::fake()->image('avatar.jpg', 1500, 1000);

        $response = $this->json('POST', route('file-upload.store'), [
            'title' => 'New_',
            'desc'  => 'Valid Description',
            'name'  => 'new_file_13.jpeg',
            'file'  => $file,
        ]);

        tap($response->json(), function ($data) use ($response) {
            $response->assertStatus(422);
            $this->assertTrue(array_key_exists('title', $data));
            $this->assertCount(2, $data['title']);
        });
    }

    /** @test */
    public function image_requires_valid_name_to_be_uploaded()
    {
        $this->signIn();

        $file = UploadedFile::fake()->image('avatar.jpg', 1500, 1000);

        $response = $this->json('POST', route('file-upload.store'), [
            'title' => 'New title',
            'desc'  => 'Valid Description',
            'file'  => $file,
        ]);

        tap($response->json(), function ($data) use ($response) {
            $response->assertStatus(422);
            $this->assertTrue(array_key_exists('name', $data));
            $this->assertCount(1, $data['name']);
        });

        $response = $this->json('POST', route('file-upload.store'), [
            'title' => 'New title',
            'desc'  => 'Valid Description',
            'name'  => 'new_file_13$.jpeg',
            'file'  => $file,
        ]);

        tap($response->json(), function ($data) use ($response) {
            $response->assertStatus(422);
            $this->assertTrue(array_key_exists('name', $data));
            $this->assertCount(1, $data['name']);
        });
    }

    /** @test */
    public function image_keywords_param_should_be_array()
    {
        $this->signIn();

        $file = UploadedFile::fake()->image('avatar.jpg', 1500, 1000);

        $response = $this->json('POST', route('file-upload.store'), [
            'title'    => 'New title',
            'desc'     => 'Valid Description',
            'file'     => $file,
            'name'     => 'new_file_13.jpeg',
            'keywords' => 'hey',
        ]);

        $this->assertTrue(
            array_key_exists('keywords', $response->json())
        );

        $response = $this->json('POST', route('file-upload.store'), [
            'title'    => 'New title',
            'desc'     => 'Valid Description',
            'file'     => $file,
            'name'     => 'new_file_13.jpeg',
            'keywords' => ['hey'],
        ]);

        $this->assertEquals('success', $response->json()['status']);
    }

    /** @test */
    public function image_keywords_with_empty_string_can_be_handled()
    {
        $this->signIn();

        $file = UploadedFile::fake()->image('avatar.jpg', 1500, 1000);

        $response = $this->json('POST', route('file-upload.store'), [
            'title'    => 'New title',
            'desc'     => 'Valid Description',
            'file'     => $file,
            'name'     => 'new_file_13.jpeg',
            'keywords' => '',
        ])->assertStatus(200);
    }

    /** @test */
    public function file_upload_response_contains_file_persisted_id()
    {
        $this->signIn();

        $file = UploadedFile::fake()->image('avatar.jpg', 1500, 1000);

        $response = $this->json('POST', route('file-upload.store'), [
            'title'    => 'New title',
            'desc'     => 'Valid Description',
            'file'     => $file,
            'name'     => 'new_file_13.jpeg',
            'keywords' => '',
        ])->json();

        $this->assertTrue(
            array_key_exists('id', $response['data'])
        );
    }

}

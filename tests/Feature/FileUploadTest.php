<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FileUploadTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('avatars');
    }

    /** @test */
    public function user_can_upload_file_to_server()
    {
        $this->signIn();

        $file = UploadedFile::fake()->image('avatar.jpg', 1500, 1000);

        $response = $this->json('POST', route('file-upload.store'), [
            'title' => 'New File',
            'desc' => 'without desc',
            'name' => 'new_file_13.jpeg',
            'file' => $file,
        ]);

        Storage::disk('avatars')->assertExists('public/' . $file->hashName());
    }

    /** @test */
    public function image_requires_valid_title_to_be_uploaded()
    {
        $this->signIn();

        $file = UploadedFile::fake()->image('avatar.jpg', 1500, 1000);

        $response = $this->json('POST', route('file-upload.store'), [
            'title' => 'New_',
            'desc' => 'Valid Description',
            'name' => 'new_file_13.jpeg',
            'file' => $file,
        ]);

        tap($response->json(), function ($data) use ($response) {
            $response->assertStatus(422);
            $this->assertTrue(array_key_exists('title', $data['data']));
            $this->assertCount(2, $data['data']['title']);
        });
    }

    /** @test */
    public function image_requires_valid_name_to_be_uploaded()
    {
        $this->signIn();

        $file = UploadedFile::fake()->image('avatar.jpg', 1500, 1000);

        $response = $this->json('POST', route('file-upload.store'), [
            'title' => 'New title',
            'desc' => 'Valid Description',
            'file' => $file,
        ]);

        tap($response->json(), function ($data) use ($response) {
            $response->assertStatus(422);
            $this->assertTrue(array_key_exists('name', $data['data']));
            $this->assertCount(1, $data['data']['name']);
        });

        $response = $this->json('POST', route('file-upload.store'), [
            'title' => 'New title',
            'desc' => 'Valid Description',
            'name' => 'new_file_13$.jpeg',
            'file' => $file,
        ]);

        tap($response->json(), function ($data) use ($response) {
            $response->assertStatus(422);
            $this->assertTrue(array_key_exists('name', $data['data']));
            $this->assertCount(1, $data['data']['name']);
        });
    }

    /** @test */
    public function image_keywords_param_should_be_array()
    {
        $this->signIn();

        $file = UploadedFile::fake()->image('avatar.jpg', 1500, 1000);

        $response = $this->json('POST', route('file-upload.store'), [
            'title' => 'New title',
            'desc' => 'Valid Description',
            'file' => $file,
            'name' => 'new_file_13.jpeg',
            'keywords' => 'hey',
        ]);

        $this->assertTrue(
            array_key_exists('keywords', $response->json()['data'])
        );

        $response = $this->json('POST', route('file-upload.store'), [
            'title' => 'New title',
            'desc' => 'Valid Description',
            'file' => $file,
            'name' => 'new_file_13.jpeg',
            'keywords' => ['hey'],
        ]);

        $this->assertEmpty($response->json());
    }
}

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
        $response = $this->createFile();

        tap($response->json()['data'], function ($data) {
            $filename = $data['hashname'] . '.' . $data['ext'];

            Storage::disk('avatars')->assertMissing('public/images/' . $filename);
        });
    }

    /** @test */
    public function user_can_upload_valid_image_to_server()
    {
        $this->createFile();

        $this->assertEquals('New File Title', \App\File::latest()->first()->title);
    }

    /** @test */
    public function image_requires_valid_title_to_be_uploaded()
    {
        $response = $this->createFile(['title' => 'New_']);

        tap($response->json(), function ($data) use ($response) {
            $response->assertStatus(422);
            $this->assertTrue(array_key_exists('title', $data));
            $this->assertCount(2, $data['title']);
        });
    }

    /** @test */
    public function image_requires_valid_name_to_be_uploaded()
    {
        // $this->signIn();

        $file = UploadedFile::fake()->image('avatar.jpg', 1500, 1000);

        $response = $this->createFile(['name' => null]);

        tap($response->json(), function ($data) use ($response) {
            $response->assertStatus(422);
            $this->assertTrue(array_key_exists('name', $data));
            $this->assertCount(1, $data['name']);
        });

        $response = $this->createFile(['name' => 'new_file_13$.jpeg']);

        tap($response->json(), function ($data) use ($response) {
            $response->assertStatus(422);
            $this->assertTrue(array_key_exists('name', $data));
            $this->assertCount(1, $data['name']);
        });
    }

    /** @test */
    public function image_keywords_param_should_be_array()
    {
        $response = $this->createFile(['keywords' => 'hey']);

        $this->assertTrue(
            array_key_exists('keywords', $response->json())
        );

        $response = $this->createFile(['keywords' => ['hey']]);

        $this->assertEquals('success', $response->json()['status']);
    }

    /** @test */
    public function image_keywords_with_empty_string_can_be_handled()
    {
        $this->createFile(['keywords' => ''])
             ->assertStatus(200);
    }

    /** @test */
    public function file_upload_response_contains_file_persisted_id()
    {
        $response = $this->createFile();

        $this->assertTrue(
            array_key_exists('id', $response->json()['data'])
        );
    }

    /** @test */
    public function uploading_regular_file_can_be_handled()
    {
        $response = $this->createFile([], 'image', 'avatar.svg')->json();

        $this->assertCount(1, $response['data']['specs']);

        $response = $this->createFile([], 'file', 'file1.pdf')->json();

        $this->assertCount(1, $response['data']['specs']);
    }

    /**
     * Description about :: createFile ::
     */
    public function createFile($overrides = [], $file = 'image', $filename = 'avatar.jpg')
    {
        $this->signIn();

        if ($file == 'image') {
            $file = UploadedFile::fake()->image($filename, 1500, 1000);
        } else {
            $file = UploadedFile::fake()->create($filename);
        }

        $defaults = [
            'title' => 'New File Title',
            'desc'  => 'Valid Description',
            'file'  => $file,
            'name'  => 'new_file_13.jpeg',
        ];

        $array = array_merge($defaults, $overrides);

        return $this->json('POST', route('file-upload.store'), $array);
    }

}

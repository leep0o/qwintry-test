<?php

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use App\Models\Document;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DocumentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp() : void
    {
        parent::setUp();
//        $this->artisan('db:seed');
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /** @test */
    public function create_document()
    {
        $this->assertEquals(0, Document::count());

        $data = [
            'name' => 'Some Name',
            'desc' => 'Description.'
        ];

        $this->postJson(route('documents.store'), $data)
            ->assertStatus(200);
        $this->assertEquals(1, Document::count());

        $document = Document::first();
        $this->assertEquals($data['name'], $document->name);
        $this->assertEquals($data['desc'], $document->desc);
    }

    /** @test */
    public function create_document_with_image()
    {
        Storage::fake('public');

        $data = [
            'name' => 'Some Name',
            'desc' => 'Description.',
            'image' => $file = UploadedFile::fake()->image('image.jpg', 1, 1)
        ];

        $this->postJson(route('documents.store'), $data)
            ->assertStatus(200);

        $document = Document::first();

        Storage::disk('public')->assertExists($document->file->full_path);
    }
}

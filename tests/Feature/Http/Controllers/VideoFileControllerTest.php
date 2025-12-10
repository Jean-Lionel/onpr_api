<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\VideoFile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\VideoFileController
 */
class VideoFileControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected()
    {
        $videoFiles = VideoFile::factory()->count(3)->create();

        $response = $this->get(route('video-file.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\VideoFileController::class,
            'store',
            \App\Http\Requests\VideoFileStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $file_path = $this->faker->word;
        $title = $this->faker->sentence(4);

        $response = $this->post(route('video-file.store'), [
            'file_path' => $file_path,
            'title' => $title,
        ]);

        $videoFiles = VideoFile::query()
            ->where('file_path', $file_path)
            ->where('title', $title)
            ->get();
        $this->assertCount(1, $videoFiles);
        $videoFile = $videoFiles->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $videoFile = VideoFile::factory()->create();

        $response = $this->get(route('video-file.show', $videoFile));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\VideoFileController::class,
            'update',
            \App\Http\Requests\VideoFileUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $videoFile = VideoFile::factory()->create();
        $file_path = $this->faker->word;
        $title = $this->faker->sentence(4);

        $response = $this->put(route('video-file.update', $videoFile), [
            'file_path' => $file_path,
            'title' => $title,
        ]);

        $videoFile->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($file_path, $videoFile->file_path);
        $this->assertEquals($title, $videoFile->title);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $videoFile = VideoFile::factory()->create();

        $response = $this->delete(route('video-file.destroy', $videoFile));

        $response->assertNoContent();

        $this->assertDeleted($videoFile);
    }
}

<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\GalleryDirection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\GalleryDirectionController
 */
class GalleryDirectionControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected()
    {
        $galleryDirections = GalleryDirection::factory()->count(3)->create();

        $response = $this->get(route('gallery-direction.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\GalleryDirectionController::class,
            'store',
            \App\Http\Requests\GalleryDirectionStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $response = $this->post(route('gallery-direction.store'));

        $response->assertCreated();
        $response->assertJsonStructure([]);

        $this->assertDatabaseHas(galleryDirections, [ /* ... */ ]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $galleryDirection = GalleryDirection::factory()->create();

        $response = $this->get(route('gallery-direction.show', $galleryDirection));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\GalleryDirectionController::class,
            'update',
            \App\Http\Requests\GalleryDirectionUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $galleryDirection = GalleryDirection::factory()->create();

        $response = $this->put(route('gallery-direction.update', $galleryDirection));

        $galleryDirection->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $galleryDirection = GalleryDirection::factory()->create();

        $response = $this->delete(route('gallery-direction.destroy', $galleryDirection));

        $response->assertNoContent();

        $this->assertDeleted($galleryDirection);
    }
}

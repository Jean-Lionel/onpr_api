<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\QuickLink;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\QuickLinkController
 */
class QuickLinkControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected()
    {
        $quickLinks = QuickLink::factory()->count(3)->create();

        $response = $this->get(route('quick-link.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\QuickLinkController::class,
            'store',
            \App\Http\Requests\QuickLinkStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $response = $this->post(route('quick-link.store'));

        $response->assertCreated();
        $response->assertJsonStructure([]);

        $this->assertDatabaseHas(quickLinks, [ /* ... */ ]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $quickLink = QuickLink::factory()->create();

        $response = $this->get(route('quick-link.show', $quickLink));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\QuickLinkController::class,
            'update',
            \App\Http\Requests\QuickLinkUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $quickLink = QuickLink::factory()->create();

        $response = $this->put(route('quick-link.update', $quickLink));

        $quickLink->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $quickLink = QuickLink::factory()->create();

        $response = $this->delete(route('quick-link.destroy', $quickLink));

        $response->assertNoContent();

        $this->assertDeleted($quickLink);
    }
}

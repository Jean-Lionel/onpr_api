<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\ContactLink;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ContactLinkController
 */
class ContactLinkControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected()
    {
        $contactLinks = ContactLink::factory()->count(3)->create();

        $response = $this->get(route('contact-link.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ContactLinkController::class,
            'store',
            \App\Http\Requests\ContactLinkStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $response = $this->post(route('contact-link.store'));

        $response->assertCreated();
        $response->assertJsonStructure([]);

        $this->assertDatabaseHas(contactLinks, [ /* ... */ ]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $contactLink = ContactLink::factory()->create();

        $response = $this->get(route('contact-link.show', $contactLink));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ContactLinkController::class,
            'update',
            \App\Http\Requests\ContactLinkUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $contactLink = ContactLink::factory()->create();

        $response = $this->put(route('contact-link.update', $contactLink));

        $contactLink->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $contactLink = ContactLink::factory()->create();

        $response = $this->delete(route('contact-link.destroy', $contactLink));

        $response->assertNoContent();

        $this->assertDeleted($contactLink);
    }
}

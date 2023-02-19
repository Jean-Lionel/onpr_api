<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Contact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ContactController
 */
class ContactControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected()
    {
        $contacts = Contact::factory()->count(3)->create();

        $response = $this->get(route('contact.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ContactController::class,
            'store',
            \App\Http\Requests\ContactStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $title_en = $this->faker->word;
        $title_fr = $this->faker->word;
        $content_en = $this->faker->text;
        $content_fr = $this->faker->text;

        $response = $this->post(route('contact.store'), [
            'title_en' => $title_en,
            'title_fr' => $title_fr,
            'content_en' => $content_en,
            'content_fr' => $content_fr,
        ]);

        $contacts = Contact::query()
            ->where('title_en', $title_en)
            ->where('title_fr', $title_fr)
            ->where('content_en', $content_en)
            ->where('content_fr', $content_fr)
            ->get();
        $this->assertCount(1, $contacts);
        $contact = $contacts->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $contact = Contact::factory()->create();

        $response = $this->get(route('contact.show', $contact));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ContactController::class,
            'update',
            \App\Http\Requests\ContactUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $contact = Contact::factory()->create();
        $title_en = $this->faker->word;
        $title_fr = $this->faker->word;
        $content_en = $this->faker->text;
        $content_fr = $this->faker->text;

        $response = $this->put(route('contact.update', $contact), [
            'title_en' => $title_en,
            'title_fr' => $title_fr,
            'content_en' => $content_en,
            'content_fr' => $content_fr,
        ]);

        $contact->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($title_en, $contact->title_en);
        $this->assertEquals($title_fr, $contact->title_fr);
        $this->assertEquals($content_en, $contact->content_en);
        $this->assertEquals($content_fr, $contact->content_fr);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $contact = Contact::factory()->create();

        $response = $this->delete(route('contact.destroy', $contact));

        $response->assertNoContent();

        $this->assertDeleted($contact);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactStoreRequest;
use App\Http\Requests\ContactUpdateRequest;
use App\Http\Resources\ContactCollection;
use App\Http\Resources\ContactResource;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\ContactCollection
     */
    public function index(Request $request)
    {
        $contacts = Contact::all();

        return new ContactCollection($contacts);
    }

    /**
     * @param \App\Http\Requests\ContactStoreRequest $request
     * @return \App\Http\Resources\ContactResource
     */
    public function store(ContactStoreRequest $request)
    {
        $contact = Contact::create($request->validated());

        return new ContactResource($contact);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Contact $contact
     * @return \App\Http\Resources\ContactResource
     */
    public function show(Request $request, Contact $contact)
    {
        return new ContactResource($contact);
    }

    /**
     * @param \App\Http\Requests\ContactUpdateRequest $request
     * @param \App\Models\Contact $contact
     * @return \App\Http\Resources\ContactResource
     */
    public function update(ContactUpdateRequest $request, Contact $contact)
    {
        $contact->update($request->validated());

        return new ContactResource($contact);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Contact $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Contact $contact)
    {
        $contact->delete();

        return response()->noContent();
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactLinkStoreRequest;
use App\Http\Requests\ContactLinkUpdateRequest;
use App\Http\Resources\ContactLinkCollection;
use App\Http\Resources\ContactLinkResource;
use App\Models\ContactLink;
use Illuminate\Http\Request;

class ContactLinkController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\ContactLinkCollection
     */
    public function index(Request $request)
    {
        $contactLinks = ContactLink::all();

        return new ContactLinkCollection($contactLinks);
    }

    /**
     * @param \App\Http\Requests\ContactLinkStoreRequest $request
     * @return \App\Http\Resources\ContactLinkResource
     */
    public function store(ContactLinkStoreRequest $request)
    {
        $contactLink = ContactLink::create($request->validated());

        return new ContactLinkResource($contactLink);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ContactLink $contactLink
     * @return \App\Http\Resources\ContactLinkResource
     */
    public function show(Request $request, ContactLink $contactLink)
    {
        return new ContactLinkResource($contactLink);
    }

    /**
     * @param \App\Http\Requests\ContactLinkUpdateRequest $request
     * @param \App\Models\ContactLink $contactLink
     * @return \App\Http\Resources\ContactLinkResource
     */
    public function update(ContactLinkUpdateRequest $request, ContactLink $contactLink)
    {
        $contactLink->update($request->validated());

        return new ContactLinkResource($contactLink);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ContactLink $contactLink
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, ContactLink $contactLink)
    {
        $contactLink->delete();

        return response()->noContent();
    }
}

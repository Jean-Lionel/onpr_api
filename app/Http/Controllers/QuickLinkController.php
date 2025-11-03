<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuickLinkStoreRequest;
use App\Http\Requests\QuickLinkUpdateRequest;
use App\Http\Resources\QuickLinkCollection;
use App\Http\Resources\QuickLinkResource;
use App\Models\QuickLink;
use Illuminate\Http\Request;

class QuickLinkController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\QuickLinkCollection
     */
    public function index(Request $request)
    {
        $quickLinks = QuickLink::all();

        return new QuickLinkCollection($quickLinks);
    }

    /**
     * @param \App\Http\Requests\QuickLinkStoreRequest $request
     * @return \App\Http\Resources\QuickLinkResource
     */
    public function store(QuickLinkStoreRequest $request)
    {
        $quickLink = QuickLink::create($request->validated());

        return new QuickLinkResource($quickLink);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\QuickLink $quickLink
     * @return \App\Http\Resources\QuickLinkResource
     */
    public function show(Request $request, QuickLink $quickLink)
    {
        return new QuickLinkResource($quickLink);
    }

    /**
     * @param \App\Http\Requests\QuickLinkUpdateRequest $request
     * @param \App\Models\QuickLink $quickLink
     * @return \App\Http\Resources\QuickLinkResource
     */
    public function update(QuickLinkUpdateRequest $request, QuickLink $quickLink)
    {
        $quickLink->update($request->validated());

        return new QuickLinkResource($quickLink);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\QuickLink $quickLink
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, QuickLink $quickLink)
    {
        $quickLink->delete();

        return response()->noContent();
    }
}

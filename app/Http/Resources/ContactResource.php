<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ContactResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title_en' => $this->title_en,
            'title_fr' => $this->title_fr,
            'content_en' => $this->content_en,
            'content_fr' => $this->content_fr,
            'published_at' => $this->published_at,
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GalleryDirectionResource extends JsonResource
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
            'name_en' => $this->name_en,
            'name_fr' => $this->name_fr,
            'description_en' => $this->description_en,
            'description_fr' => $this->description_fr,
            'image_url' => $this->image_url,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

<?php

namespace Modules\Catalog\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CatalogProductImagesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'mediaType' => $this->media_type,
            'mediaFile' => $this->media_file,
            'mediaUrl' => $this->media_url
        ];
    }

}

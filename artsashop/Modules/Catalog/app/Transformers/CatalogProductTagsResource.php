<?php

namespace Modules\Catalog\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CatalogProductTagsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'tagName' => $this->tag_name,
            'tagSlugKey' => $this->slug_key
        ];
    }
}

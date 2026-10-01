<?php

namespace Modules\Eav\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EavAttributeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            "attributeCode" => $this->attribute_code,
            "attributeLabel" => $this->attribute_label,
            "frontendInput" => $this->frontend_input,
            "defaultValue" => json_decode($this->default_value),
            "values" => json_decode($this->values),
            "isRequired" => $this->is_required,
            "note" => $this->note,
        ];
    }
}

<?php
/**
 * Fabiano Gato
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 *
 * Não editar ou acrescentar à este arquivo se você quiser fazer o upgrade para versões
 * mais recentes no futuro.
 *****************************************************
 *
 * @copyright    Copyright (c) Fabiano Gato
 * @author       Fabiano Gato <fabianogattoti@gmail.com>
 *
 */
namespace Modules\Eav\Transformers;

use Idea\Framework\Concerns\ResultApiResponse;
use Idea\Framework\Repository\Eav\EavAttributesRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EavAttributeSetResource extends JsonResource
{

    use ResultApiResponse;

    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {

        return $this->response([
            "attributeSetKey" => $this->attribute_set_key,
            "attributeSetName" => $this->attribute_set_name,
            "stemmingWords" => $this->stemming_words,
            "productQty" => $this->product_qty,
            "productQtyEnable" => $this->product_qty_enable,
            "productQtyDisable" => $this->product_qty_disable,
            "productQtyExcluded" => $this->product_qty_excluded,
            "status" => $this->status,
            "attributes" => EavAttributeResource::collection(
                EavAttributesRepository::getAttributesBySetId($this->attribute_set_id)->get()
            ),
        ]);
    }

}

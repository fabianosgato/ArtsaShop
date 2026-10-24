<?php
/**
 * Fabiano Gato
 *
 * NOTICE OF LICENSE
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 *
 * É concedida permissão, gratuitamente, a qualquer pessoa que obtenha uma cópia
 * deste software e arquivos de documentação associados
 *
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

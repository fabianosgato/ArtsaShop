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
namespace Modules\System\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StoresResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'storeId' => $this->store_id,
            'code' => $this->code,
            'host' => $this->host,
            'storeName' => $this->store_name,
            'storeType' => $this->type,
            'isDefault' => $this->is_default,
        ];
    }

}

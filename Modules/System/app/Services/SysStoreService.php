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

namespace Modules\System\Services;

use App\Models\SysStore;
use Idea\Framework\Repository\System\SysStoreRepository;

class SysStoreService
{

    /**
     * Desativa o default das outras lojas
     * @return void
     */
    private function disableStoresDefault()
    {

        // Retorna as outras lojas
        $stores = SysStoreRepository::getStores();

        // Lista as lojas para desativar o default de todas
        foreach ($stores as $store) {
            SysStoreRepository::find($store->store_id)
                ->update([
                    'is_default' => false
                ]);
        }

    }

    /**
     * Salva as alterações da loja
     * @param $storeData
     * @return \App\Models\SysStore
     */
    public function saveStore($storeData): SysStore
    {

        // Valida o ID da loja para atualização
        if (!empty($storeData['store_id'])) {

            // Valida se a loja foi marcada como default
            if ($storeData['is_default']) {
                // Desativa o default das outras lojas
                $this->disableStoresDefault();
            }

            // Atualiza as informações da loja
            return SysStoreRepository::getData()->updateOrCreate(
                attributes: [
                    'store_id' => $storeData['store_id'],
                    'code' => $storeData['code'],
                ],
                values: $storeData
            );

        } else {

            // Atualiza as informações da loja
            return SysStoreRepository::getData()->firstOrCreate(
                attributes: [
                    'code' => $storeData['code']
                ],
                values: $storeData
            );

        }

    }

}

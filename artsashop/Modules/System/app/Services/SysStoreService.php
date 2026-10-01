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

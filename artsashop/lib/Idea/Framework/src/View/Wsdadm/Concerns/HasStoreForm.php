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
namespace Idea\Framework\View\Wsdadm\Concerns;

use Filament\Forms\Components\Checkbox;
use Filament\Schemas\Components\Tabs;
use Idea\Framework\Repository\Catalog\CatalogProductStoreRepository;
use Idea\Framework\Repository\System\SysStoreRepository;

trait HasStoreForm
{

    protected function mountStore(array $data): void
    {

        $this->applyStoreDefault($data);
        $this->resolveStorePage();

    }

    protected function applyStoreDefault(array $data)
    {
        $this->data = $data;

        $this->data['store'] = array_replace(
            $this->storePageDefaults(),
            ...$this->data['store'] ?? []
        );

    }

    protected function storePageDefaults(): array
    {
        return [
            'store.1' => true
        ];
    }

    protected function resolveStorePage(): void
    {

        // Valida se o produto está vinculado a loja
        $catalogProductStores = CatalogProductStoreRepository::getProductStores(
            productId: $this->seoObjectId()
        );

        if ($catalogProductStores) {
            foreach ($catalogProductStores as $catalogProductStore) {
                $this->data['store'][$catalogProductStore->store_id] = true;
            }

        }

    }

    /**
     * FilamentTab para armazenar o form de lojas
     */
    protected function storeTab()
    {
        return Tabs::make('Lojas')->schema(
            $this->formStores()
        );
    }

    /**
     * Cria o formulário de lojas
     * @return array
     */
    protected function formStores()
    {

        $formStores = [];

        // Lojas cadastradas no sistema
        $stores = SysStoreRepository::getStores();

        foreach ($stores as $store) {

            $name = "store.{$store->store_id}";

            if ($store->code == 'default')
                $formStores[] = Checkbox::make($name)
                    ->name($store->store_name)
                    ->helperText("Todos os produtos precisam pertencer a loja padrão");
            else
                $formStores[] = Checkbox::make($name)
                    ->name($store->store_name)
                    ->helperText("Loja : {$store->host}");

        }

        return $formStores;

    }



}

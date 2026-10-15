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

use Idea\Framework\Repository\System\SysConfigRespository;
use Idea\Framework\Seo\Data\SeoPageData;
use Idea\Framework\Seo\SeoManager;
use Illuminate\Database\Eloquent\Model;

if (! function_exists('getConfigData')) {

    /**
     * Retorna uma configuração do sistema
     * @param $path
     * @return mixed|null
     */
    function getConfigData($path): mixed
    {

        $configs = SysConfigRespository::getConfigs();
        if (isset($configs[$path])) {
            return $configs[$path];
        }
        return null;

    }

}

/**
 * Metodo responsável por retornar o publicKey do Pagarme correto na aplicação
 */
if (! function_exists('getPagarmePublicKey')) {
    function getPagarmePublicKey()
    {
        if (getConfigData('payments/pagarme/environment') == 'SANDBOX') {
            return getConfigData('payments/pagarme/sandbox_public_key');
        } else {
            return getConfigData('payments/pagarme/production_public_key');
        }
    }
}



if (!function_exists('seo')) {

    function seo(Model|SeoPageData|array|null $source = null): string
    {
        if (!$source) {
            return '';
        }

        return app(SeoManager::class)
            ->set($source)
            ->render();
    }

}

if (!function_exists('formatPrice')) {
    function formatPrice($price): string
    {
        $fmt = new \NumberFormatter('pt_BR', \NumberFormatter::CURRENCY);
        return $fmt->formatCurrency($price, "BRL") . "\n";
    }
}

if (!function_exists('getCmsBlock')) {
    function getCmsBlock($identifier): string
    {
        return \Idea\Framework\Repository\Cms\CmsBlockRepository::getCmsBlock($identifier);
    }
}



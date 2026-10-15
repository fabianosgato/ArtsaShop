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
namespace Idea\Framework\Admin;

use App\Models\SysConfigDatum;

class SystemConfig
{

    public static function get(string $path)
    {
        $config = SysConfigDatum::query()
            ->where('path', $path)
            ->first();

        if ($config) {
            return $config->value;
        }

        return false;

    }

    /**
     * Metodo responsavel por setar a cor quando oo pedido esta como Entregue, porem o status no BBexp está diferente
     * @param $record
     * @return string|void
     */
    public static function setColorOrder($record)
    {

        // Classe CSS padrao para retorno
        $cssClass = 'adm-bg-shipped';

        if ($record->status == 'shipped'){

            switch ($record->descricao_status) {
                case 'Pedido Cancelado':
                case 'Produto Devolvido':
                case 'Produto Devolvido com Avaria':
                case 'Produto Não Devolvido':
                case 'Produto Em Resgate':
                case 'Pedido Reembolsado':
                    $cssClass = 'adm-bg-red-50';
                    break;

            }

            return $cssClass;

        }

    }

}

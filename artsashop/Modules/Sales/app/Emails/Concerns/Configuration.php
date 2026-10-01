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
namespace Modules\Sales\Emails\Concerns;

trait Configuration
{

    public function getEmails(): array
    {

        if (config('app.env') == 'production') {
            return [
                'fabianogattoti@gmail.com'
            ];
        } else {
            return [
                'fabianogattoti@gmail.com'
            ];
        }

    }

}

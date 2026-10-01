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

namespace Idea\Framework\Concerns;

use Idea\Framework\Repository\System\SysConfigRespository;

trait EmailConfiguration
{

    public function addressSend(): mixed
    {
        return app(SysConfigRespository::class)->getConfig(
            path: 'trans_email/ident_general/email'
        );
    }

    public function addressName(): mixed
    {
        return app(SysConfigRespository::class)->getConfig(
            path: 'trans_email/ident_general/name'
        );
    }

    public function getEmails(): array
    {
        return match (config('app.env')) {
            'production' => [
                'fabianogattoti@gmail.com',
            ],

            default => [
                'fabianogattoti@gmail.com',
            ],
        };
    }

}

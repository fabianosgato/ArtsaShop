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

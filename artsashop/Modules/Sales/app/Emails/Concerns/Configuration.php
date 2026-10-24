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

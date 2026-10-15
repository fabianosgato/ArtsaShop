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
namespace Idea\Framework\Concerns\Validators;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

trait PasswordTokenValidator
{

    public function validateResetToken(string $token)
    {
        $records = DB::table('sys_password_reset_tokens')->get();

        foreach ($records as $record) {

            if (Hash::check($token, $record->token)) {

                $created = Carbon::parse($record->created_at);

                if ($created->addMinutes(60)->isPast()) {
                    return null;
                }

                return $record;
            }
        }

        return null;
    }

    /**
     * Remove o token de alteração de senha do sistema
     * @param string $email
     * @return void
     */
    public function removeToken(string $email): void
    {

        // Remove da tabela o email do cliente
        DB::table('sys_password_reset_tokens')
            ->where('email', '=', $email)
            ->delete();

    }

}

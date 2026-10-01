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

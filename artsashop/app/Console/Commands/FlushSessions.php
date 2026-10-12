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
namespace App\Console\Commands;

use Illuminate\Console\Command;

class FlushSessions extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'app:flush-sessions';

    /**
     * The console command description.
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
    }
}

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

use Idea\Framework\Services\SiteMapService;
use Illuminate\Console\Command;

class GenerateSitemapCommand extends Command
{
    protected $signature = 'sitemap:generate';

    protected $description = 'Generate sitemap files';

    public function handle(): int
    {
        $this->info('Gerando sitemap...');

        try {

            app(SiteMapService::class)->generate();

            $this->info('Sitemap gerado com sucesso!');
            return Command::SUCCESS;

        } catch (\Throwable $e) {

            $this->error('Erro ao gerar sitemap: ' . $e->getMessage());
            return Command::FAILURE;
        }

    }

}

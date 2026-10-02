<?php

namespace App\Console\Commands;

use Idea\Framework\Services\IndexerService;
use Illuminate\Console\Command;

class CommandIndexerProducts extends Command
{

    protected $signature = 'catalog:indexer';

    protected $description = 'Reindexa os produtos do catálogo';

    public function handle(): int
    {

        $this->info('Reindex...');

        try {

            app(IndexerService::class)->reindex();

            $this->info('Reindexação Finalizada!');
            return Command::SUCCESS;

        } catch (\Throwable $e) {

            $this->error('Erro ao gerar sitemap: ' . $e->getMessage());
            return Command::FAILURE;
        }

    }



}

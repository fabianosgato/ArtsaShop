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

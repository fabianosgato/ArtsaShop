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

use Idea\Framework\Services\SiteMapService;
use Illuminate\Console\Command;

class GenerateSitemapCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     */
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

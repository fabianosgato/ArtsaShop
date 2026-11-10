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

use App\Models\CatalogCategoryEntity;
use App\Models\CatalogProduct;
use App\Models\CatalogProductBrand;
use App\Models\CmsPage;
use App\Models\SysUrlRewrite;
use Illuminate\Console\Command;

class CommandIndexerUrlRewrite extends Command
{
    protected $signature = 'urlrewrite:index
                            {--dry-run : Apenas simula, não apaga nada}
                            {--batch=1000 : Tamanho do lote para processamento}
                            {--type= : Filtrar por tipo específico (product,category,brand,cms)}';

    protected $description = 'Valida e limpa URL Rewrites órfãos (sem entidade alvo existente)';

    public function handle(): int
    {
        $dryRun = $this->option('dry-run');
        $batchSize = (int) $this->option('batch');
        $filterType = $this->option('type');

        $this->info('=== URL Rewrite Indexer ===');
        $this->info("Modo: " . ($dryRun ? 'DRY-RUN (simulação)' : 'EXECUÇÃO REAL'));
        $this->info("Batch size: {$batchSize}");
        if ($filterType) {
            $this->info("Filtrando por tipo: {$filterType}");
        }

        $stats = [
            'total' => 0,
            'valid' => 0,
            'orphaned' => 0,
            'deleted' => 0,
            'errors' => 0,
            'by_type' => [],
        ];

        $query = SysUrlRewrite::query()
            ->orderBy('url_rewrite_id');

        if ($filterType) {
            $query->where('target_type', '=', $filterType);
        }

        $totalCount = (clone $query)->count();
        $this->info("Total de registros para processar: {$totalCount}");

        if ($totalCount === 0) {
            $this->warn('Nenhum registro encontrado.');
            return Command::SUCCESS;
        }

        $progressBar = $this->output->createProgressBar($totalCount);
        $progressBar->setFormat(' %current%/%max% [%bar%] %percent:3s%% %elapsed:6s%/%estimated:-6s% %memory:6s%');

        $query->chunkById($batchSize, function ($records) use (&$stats, $dryRun, $progressBar) {
            foreach ($records as $rewrite) {
                $stats['total']++;
                $type = $rewrite->target_type ?? 'unknown';

                // Inicializa contador por tipo
                if (!isset($stats['by_type'][$type])) {
                    $stats['by_type'][$type] = ['valid' => 0, 'orphaned' => 0, 'deleted' => 0];
                }

                $isValid = $this->validateTarget($rewrite);

                if ($isValid) {
                    $stats['valid']++;
                    $stats['by_type'][$type]['valid']++;
                } else {
                    $stats['orphaned']++;
                    $stats['by_type'][$type]['orphaned']++;

                    if (!$dryRun) {
                        try {
                            $rewrite->delete();
                            $stats['deleted']++;
                            $stats['by_type'][$type]['deleted']++;
                        } catch (\Throwable $e) {
                            $stats['errors']++;
                            $this->error("Erro ao deletar URL rewrite ID {$rewrite->url_rewrite_id}: {$e->getMessage()}");
                        }
                    }
                }

                $progressBar->advance();
            }
        });

        $progressBar->finish();
        $this->newLine(2);

        // Relatório final
        $this->printReport($stats, $dryRun);

        return Command::SUCCESS;
    }

    /**
     * Valida se a entidade alvo do URL Rewrite existe
     */
    protected function validateTarget(SysUrlRewrite $rewrite): bool
    {
        $targetPath = $rewrite->target_path;
        $targetType = $rewrite->target_type;

        if (!$targetPath || !$targetType) {
            return false;
        }

        // Extrai ID do target_path (formato: type/id)
        $parts = explode('/', $targetPath);
        if (count($parts) !== 2) {
            return false;
        }

        $id = (int) $parts[1];
        if ($id <= 0) {
            return false;
        }

        return match ($targetType) {
            'product' => CatalogProduct::query()->where('product_id', '=', $id)->exists(),
            'category' => CatalogCategoryEntity::query()->where('entity_id', '=', $id)->exists(),
            'brand' => CatalogProductBrand::query()->where('brand_id', '=', $id)->exists(),
            'cms' => CmsPage::query()->where('page_id', '=', $id)->exists(),
            default => false,
        };
    }

    /**
     * Imprime relatório final
     */
    protected function printReport(array $stats, bool $dryRun): void
    {
        $this->info('=== RELATÓRIO FINAL ===');
        $this->table(
            ['Métrica', 'Valor'],
            [
                ['Total processados', $stats['total']],
                ['Válidos (entidade existe)', $stats['valid']],
                ['Órfãos (entidade NÃO existe)', $stats['orphaned']],
                ['Deletados' . ($dryRun ? ' (simulados)' : ''), $dryRun ? $stats['orphaned'] : $stats['deleted']],
                ['Erros', $stats['errors']],
            ]
        );

        if (!empty($stats['by_type'])) {
            $this->info('=== POR TIPO ===');
            $rows = [];
            foreach ($stats['by_type'] as $type => $data) {
                $rows[] = [
                    $type,
                    $data['valid'],
                    $data['orphaned'],
                    $dryRun ? $data['orphaned'] : $data['deleted'],
                ];
            }
            $this->table(
                ['Tipo', 'Válidos', 'Órfãos', 'Deletados' . ($dryRun ? ' (sim.)' : '')],
                $rows
            );
        }

        if ($dryRun) {
            $this->warn('⚠️  MODO DRY-RUN: Nenhum registro foi realmente deletado.');
            $this->info('Para executar de verdade: php artisan urlrewrite:index');
        }
    }
}

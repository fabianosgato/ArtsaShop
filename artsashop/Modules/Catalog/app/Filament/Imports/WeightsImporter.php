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

namespace Modules\Catalog\Filament\Imports;

use App\Models\CatalogProduct;
use App\Models\MarketplaceRhpAttributesSet;
use Carbon\CarbonInterface;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Idea\Framework\Repository\Catalog\CatalogProductsRepository;


class WeightsImporter extends Importer
{

    protected static ?string $model = CatalogProduct::class;

    protected static ?string $title = 'Importar Pesos do sistema';

    /**
     * The number of times the job may be attempted.
     * @var int
     */
    public int $tries = 1;

    /**
     * The maximum number of unhandled exceptions to allow before failing.
     * @var int
     */
    public int $maxExceptions = 1;


    public static function getColumns(): array
    {
        return [
            ImportColumn::make('item_code')
                ->label('ASIN')
                ->requiredMapping(),
            ImportColumn::make('weight')
                ->label('Peso')
                ->requiredMapping()
        ];
    }

    public function getJobRetryUntil(): ?CarbonInterface
    {
        return now()->addMinutes(1);
    }

    /**
     */
    public function resolveRecord(): ?CatalogProduct
    {

        // Atualiza os pesos do produto
        CatalogProductsRepository::updateWeights($this->data);

        return null;

    }

    public static function getCompletedNotificationBody(Import $import): string
    {

        $body = 'Your rhp category import import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}

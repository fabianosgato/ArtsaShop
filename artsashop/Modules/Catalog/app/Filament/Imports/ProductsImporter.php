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


use App\Models\AmazonImporter;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Idea\Framework\Utils;

class ProductsImporter extends Importer
{

    protected static ?string $model = AmazonImporter::class;

    protected static ?string $title = 'Importar Novos Produtos';


    public static function getColumns(): array
    {
        return [
            ImportColumn::make('asin')
                ->label('ASIN')
                ->requiredMapping(),
        ];
    }

    /**
     * Importa os Asins
     */
    public function resolveRecord(): ?AmazonImporter
    {
        return AmazonImporter::firstOrNew([
            'asin' => Utils::clearAsin($this->data['asin']),
        ]);
    }

    /**
     * @param \Filament\Actions\Imports\Models\Import $import
     * @return string
     */
    public static function getCompletedNotificationBody(Import $import): string
    {

        $body = 'Importação de produtos completa com' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' produtos importados.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;

    }

}

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
namespace Modules\Catalog\Filament\Imports;

use App\Models\CatalogProduct;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Idea\Framework\Repository\Catalog\CatalogProductsRepository;
use Idea\Framework\Utils;

class ProductsImporter extends Importer
{

    protected static ?string $model = CatalogProduct::class;

    protected static ?string $title = 'Importar Novos Produtos';


    public static function getColumns(): array
    {
        return [
            ImportColumn::make('product_sku')
                ->label('Sku do produto')
                ->requiredMapping(),
        ];
    }

    /**
     * Importa os SKUs dos produtos
     */
    public function resolveRecord(): ?CatalogProduct
    {
        return CatalogProductsRepository::firstOrNew([
            'asin' => Utils::clearSku($this->data['product_sku']),
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

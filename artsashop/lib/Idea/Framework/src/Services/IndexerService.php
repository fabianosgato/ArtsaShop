<?php

namespace Idea\Framework\Services;

use Idea\Framework\Repository\Catalog\CatalogProductsRepository;
use Modules\Catalog\Services\CatalogProductMediaService;
use Modules\Catalog\Tasks\ReindexProductImagesTask;
use Spatie\Async\Pool;

class IndexerService
{
    public function __construct(
        protected CatalogProductsRepository $catalogProductsRepository
    )
    {
    }

    public function reindex(): void
    {

        // Retorna todos os produtos da base
        $catalogProducts = $this->catalogProductsRepository::getProducts()
            ->orderBy(
                column: 'product_id',
                direction:'desc'
            )
            ->get();

        foreach ($catalogProducts as $index => $catalogProduct) {

            print("$index : {$catalogProduct->product_id} {$catalogProduct->sku} : {$catalogProduct->name} \n");

            CatalogProductMediaService::proccessAllImages(
                catalogProduct: $catalogProduct
            );

        }

    }

    public function reindexall(): void
    {

        $pool = Pool::create()
            ->autoload(base_path('vendor/autoload.php'))
            ->concurrency(5)
            ->timeout(120);

        $catalogProducts = $this->catalogProductsRepository
            ->getProducts()
            ->orderBy('product_id', 'desc')
            ->limit(10)
            ->cursor();

        foreach ($catalogProducts as $index => $catalogProduct) {

            $pool->add(
                    new ReindexProductImagesTask(
                        productId: $catalogProduct->product_id,
                        index: $index,
                    )
                )
                ->then(function ($output) {
                    echo $output.PHP_EOL;
                })
                ->catch(function (\Throwable $exception) {
                    echo "ERRO no processo: "
                        . $exception->getMessage()
                        . "\n";
                })
                ->timeout(function() {
                    echo "Process took too long \n";
                });
        }

        $pool->wait();
    }
}

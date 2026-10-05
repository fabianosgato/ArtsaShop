<?php

namespace Modules\Catalog\Tasks;

use Idea\Framework\Repository\Catalog\CatalogProductsRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Catalog\Services\CatalogProductMediaService;
use Spatie\Async\Task;

class ReindexProductImagesTask extends Task
{
    public function __construct(
        protected int $productId,
        protected int $index,
    )
    {
    }

    public function configure()
    {
        $app = require dirname(__DIR__, 4) . '/bootstrap/app.php';
        $kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
        $kernel->bootstrap();
    }

    public function run(): string
    {

        DB::disconnect();

        $product = CatalogProductsRepository::getProductById(
            $this->productId
        );

        if (!$product) {
            return "[{$this->index}] Produto não encontrado.";
        }

        Log::info("[{$this->index}] Processando: {$product->sku} - {$product->name}");

        CatalogProductMediaService::proccessAllImages(
            catalogProduct: $product
        );

        return "[{$this->productId}] Concluído: {$product->sku}";

    }

}

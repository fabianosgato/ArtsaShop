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
declare(strict_types=1);

namespace Idea\Framework\Repository\Brand\Contracts;

use App\Models\CatalogProductBrand;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface CatalogProductBrandRepositoryInterface
{
    public function getBrand(int $brandId): ?CatalogProductBrand;
    public function getBrands(int $perPage = 20): LengthAwarePaginator;
    public function getBrandByKey(string $brandKey): ?CatalogProductBrand;
    public function deleteBrand(int $brandId): void;
}

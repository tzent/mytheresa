<?php
/*
 * (c) Tzvetelin Tzvetkov <tzvetelin.tzvetkov@gmail.com>
 */

declare(strict_types=1);

namespace MT\Domain\Interfaces\Handler;

use MT\Application\Interfaces\Rest\Request\ProductsCollectionRequestInterface;

interface ProductsHandlerInterface
{
    /**
     * @param  ProductsCollectionRequestInterface $collectionRequest
     * @return array
     */
    public function search(ProductsCollectionRequestInterface $collectionRequest): array;
}

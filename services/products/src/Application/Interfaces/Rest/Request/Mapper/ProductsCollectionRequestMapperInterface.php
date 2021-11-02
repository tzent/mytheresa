<?php
/*
 * (c) Tzvetelin Tzvetkov <tzvetelin.tzvetkov@gmail.com>
 */

declare(strict_types=1);

namespace MT\Application\Interfaces\Rest\Request\Mapper;

use MT\Application\Interfaces\Rest\Request\ProductsCollectionRequestInterface;
use Symfony\Component\HttpFoundation\Request;

interface ProductsCollectionRequestMapperInterface
{
    public const RESULTS_LIMIT = 5;

    /**
     * @param  Request                                 $request
     * @return ProductsCollectionRequestInterface|null
     */
    public function toProductsCollectionRequest(Request $request) : ?ProductsCollectionRequestInterface;
}

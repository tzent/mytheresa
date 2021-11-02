<?php
/*
 * (c) Tzvetelin Tzvetkov <tzvetelin.tzvetkov@gmail.com>
 */

declare(strict_types=1);

namespace MT\Application\Interfaces\Rest\Response\Mapper;

use MT\Application\Interfaces\Rest\Response\ProductWithDiscountResponseInterface;
use MT\Domain\Entity\Discount;
use MT\Domain\Entity\Product;

interface ProductWithDiscountResponseMapperInterface
{
    /**
     * @param  Product                              $product
     * @param  Discount|null                        $discount
     * @return ProductWithDiscountResponseInterface
     */
    public function toProductWithDiscountResponse(Product $product, ?Discount $discount): ProductWithDiscountResponseInterface;
}

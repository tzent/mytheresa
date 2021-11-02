<?php
/*
 * (c) Tzvetelin Tzvetkov <tzvetelin.tzvetkov@gmail.com>
 */

declare(strict_types=1);

namespace MT\Domain\Interfaces\Handler;

use MT\Domain\Entity\Discount;
use MT\Domain\Entity\Product;

interface DiscountsHandlerInterface
{
    /**
     * @param  Product       $product
     * @return Discount|null
     */
    public function findDiscount(Product $product): ?Discount;

    /**
     * @param  int $totalPrice
     * @param  int $discountPercentage
     * @return int
     */
    public function calculateDiscountPrice(int $totalPrice, int $discountPercentage): int;
}

<?php
/*
 * (c) Tzvetelin Tzvetkov <tzvetelin.tzvetkov@gmail.com>
 */

declare(strict_types=1);

namespace MT\Domain\Handler;

use MT\Domain\Entity\Discount;
use MT\Domain\Entity\Product;
use MT\Domain\Interfaces\Handler\DiscountsHandlerInterface;
use MT\Infrastructure\Interfaces\Repository\DiscountsRepositoryInterface;

final class DiscountsHandler implements DiscountsHandlerInterface
{
    /**
     * @var DiscountsRepositoryInterface
     */
    private DiscountsRepositoryInterface $discountsRepository;

    public function __construct(
        DiscountsRepositoryInterface $discountsRepository
    ) {
        $this->discountsRepository = $discountsRepository;
    }

    /**
     * @param  Product       $product
     * @return Discount|null
     */
    public function findDiscount(Product $product): ?Discount
    {
        $appliedDiscount = null;
        /** @var Discount $discount */
        foreach ($this->getDiscounts() as $discount) {
            if ($this->isDiscountApplicable($product, $discount) &&
                (null === $appliedDiscount || $discount->getDiscount() > $appliedDiscount->getDiscount())
            ) {
                $appliedDiscount = $discount;
            }
        }

        return $appliedDiscount;
    }

    /**
     * @param  int $totalPrice
     * @param  int $discountPercentage
     * @return int
     */
    public function calculateDiscountPrice(int $totalPrice, int $discountPercentage): int
    {
        return $totalPrice - intval($totalPrice * ($discountPercentage / 100));
    }

    /**
     * @return array
     */
    private function getDiscounts(): array
    {
        static $discounts = [];

        if (empty($discounts)) {
            $discounts = $this->discountsRepository->findBy();
        }

        return $discounts;
    }

    /**
     * @param  Product  $product
     * @param  Discount $discount
     * @return bool
     */
    private function isDiscountApplicable(Product $product, Discount $discount): bool
    {
        $condition = $discount->getCondition();
        $field     = key($condition);
        $value     = current($condition);

        return property_exists($product, $field) && $product->{$field} === $value;
    }
}

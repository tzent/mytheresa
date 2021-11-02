<?php

namespace MT\Application\Rest\Response\Mapper;

use MT\Application\Interfaces\Rest\Response\Mapper\ProductWithDiscountResponseMapperInterface;
use MT\Application\Interfaces\Rest\Response\ProductWithDiscountResponseInterface;
use MT\Application\Rest\Response\ProductWithDiscountResponse;
use MT\Domain\Entity\Discount;
use MT\Domain\Entity\Product;
use MT\Domain\Interfaces\Handler\DiscountsHandlerInterface;
use stdClass;

class ProductWithDiscountResponseMapper implements ProductWithDiscountResponseMapperInterface
{
    /**
     * @var DiscountsHandlerInterface
     */
    private DiscountsHandlerInterface $discountsHandler;

    /**
     * @param DiscountsHandlerInterface $discountsHandler
     */
    public function __construct(DiscountsHandlerInterface $discountsHandler)
    {
        $this->discountsHandler = $discountsHandler;
    }

    /**
     * @param  Product                              $product
     * @param  Discount|null                        $discount
     * @return ProductWithDiscountResponseInterface
     */
    public function toProductWithDiscountResponse(Product $product, ?Discount $discount): ProductWithDiscountResponseInterface
    {
        return new ProductWithDiscountResponse(
            sku: $product->getSku(),
            name: $product->getName(),
            category: $product->getCategory(),
            price: $this->getPrice($product, $discount)
        );
    }

    /**
     * @param  Product       $product
     * @param  Discount|null $discount
     * @return object
     */
    private function getPrice(Product $product, ?Discount $discount): object
    {
        $discountPercentage  = null;
        $finalPrice          = $product->getPrice();
        if (!empty($discount)) {
            $discountPercentage = $discount->getDiscount();

            $finalPrice          = $this->discountsHandler->calculateDiscountPrice(
                totalPrice: $product->getPrice(),
                discountPercentage: $discountPercentage
            );
        }

        $price                      = new stdClass();
        $price->original            = $product->getPrice();
        $price->final               = $finalPrice;
        $price->discount_percentage = $discountPercentage;
        $price->currency            = 'EUR';

        return $price;
    }
}

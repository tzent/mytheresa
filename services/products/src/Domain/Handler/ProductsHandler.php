<?php
/*
 * (c) Tzvetelin Tzvetkov <tzvetelin.tzvetkov@gmail.com>
 */

declare(strict_types=1);

namespace MT\Domain\Handler;

use MT\Application\Interfaces\Rest\Request\ProductsCollectionRequestInterface;
use MT\Domain\Interfaces\Handler\DiscountsHandlerInterface;
use MT\Domain\Interfaces\Handler\ProductsHandlerInterface;
use MT\Infrastructure\Interfaces\Repository\ProductsRepositoryInterface;

final class ProductsHandler implements ProductsHandlerInterface
{
    /**
     * @var ProductsRepositoryInterface
     */
    private ProductsRepositoryInterface $productsRepository;

    /**
     * @var DiscountsHandlerInterface
     */
    private DiscountsHandlerInterface $discountsHandler;

    /**
     * @param ProductsRepositoryInterface $productsRepository
     * @param DiscountsHandlerInterface   $discountsHandler
     */
    public function __construct(
        ProductsRepositoryInterface $productsRepository,
        DiscountsHandlerInterface $discountsHandler
    ) {
        $this->productsRepository = $productsRepository;
        $this->discountsHandler   = $discountsHandler;
    }

    /**
     * @param  ProductsCollectionRequestInterface $collectionRequest
     * @return array
     */
    public function search(ProductsCollectionRequestInterface $collectionRequest): array
    {
        $result = [];

        $products = $this->productsRepository->findBy(
            criteria: [
                'category'      => $collectionRequest->getCategory(),
                'priceLessThan' => $collectionRequest->getPriceLessThan()
            ],
            options: [
                'limit' => $collectionRequest->getLimit()
            ]
        );

        foreach ($products as $product) {
            $discount = $this->discountsHandler->findDiscount($product);
            $result[] = [
                'product'  => $product,
                'discount' => $discount
            ];
        }

        return $result;
    }
}

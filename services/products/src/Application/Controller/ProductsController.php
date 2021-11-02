<?php
/*
 * (c) Tzvetelin Tzvetkov <tzvetelin.tzvetkov@gmail.com>
 */

declare(strict_types=1);

namespace MT\Application\Controller;

use MT\Application\Interfaces\Rest\Request\Mapper\ProductsCollectionRequestMapperInterface;
use MT\Application\Interfaces\Rest\Response\Mapper\ProductWithDiscountResponseMapperInterface;
use MT\Domain\Interfaces\Handler\ProductsHandlerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/products')]
final class ProductsController extends AbstractController
{
    /**
     * @var ProductsHandlerInterface
     */
    private ProductsHandlerInterface $productsHandler;

    /**
     * @var ProductsCollectionRequestMapperInterface
     */
    private ProductsCollectionRequestMapperInterface $collectionRequestMapper;

    /**
     * @var ProductWithDiscountResponseMapperInterface
     */
    private ProductWithDiscountResponseMapperInterface $productResponseMapper;

    /**
     * @param ProductsHandlerInterface                   $productsHandler
     * @param ProductsCollectionRequestMapperInterface   $collectionRequestMapper
     * @param ProductWithDiscountResponseMapperInterface $productResponseMapper
     */
    public function __construct(
        ProductsHandlerInterface $productsHandler,
        ProductsCollectionRequestMapperInterface $collectionRequestMapper,
        ProductWithDiscountResponseMapperInterface $productResponseMapper
    ) {
        $this->productsHandler         = $productsHandler;
        $this->collectionRequestMapper = $collectionRequestMapper;
        $this->productResponseMapper   = $productResponseMapper;
    }

    /**
     * @param  Request      $request
     * @return JsonResponse
     */

    #[Route(path: '', name: 'products-collection', methods: ['GET'])]
    public function collection(Request $request): JsonResponse
    {
        $productsCollectionRequest = $this->collectionRequestMapper->toProductsCollectionRequest($request);

        if ($this->collectionRequestMapper->hasErrors()) {
            return $this->json(
                ['error' => $this->collectionRequestMapper->getFirstError()],
                Response::HTTP_BAD_REQUEST
            );
        }

        $products = $this->productsHandler->search($productsCollectionRequest);

        $mappedProducts = [];
        foreach ($products as $product) {
            $mappedProducts[] = $this->productResponseMapper->toProductWithDiscountResponse(
                $product['product'],
                $product['discount']
            );
        }

        return $this->json($mappedProducts, Response::HTTP_OK, ['groups' => 'collection']);
    }
}

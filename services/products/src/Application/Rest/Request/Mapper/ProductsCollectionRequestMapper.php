<?php
/*
 * (c) Tzvetelin Tzvetkov <tzvetelin.tzvetkov@gmail.com>
 */

declare(strict_types=1);

namespace MT\Application\Rest\Request\Mapper;

use MT\Application\Interfaces\Rest\Request\Mapper\ProductsCollectionRequestMapperInterface;
use MT\Application\Interfaces\Rest\Request\ProductsCollectionRequestInterface;
use MT\Application\Rest\Request\ProductsCollectionRequest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class ProductsCollectionRequestMapper extends AbstractRequestMapper implements ProductsCollectionRequestMapperInterface
{
    /**
     * @var ValidatorInterface
     */
    private ValidatorInterface $validator;

    /**
     * @param ValidatorInterface $validator
     */
    public function __construct(ValidatorInterface $validator)
    {
        parent::__construct();

        $this->validator = $validator;
    }

    /**
     * @param  Request                                 $request
     * @return ProductsCollectionRequestInterface|null
     */
    public function toProductsCollectionRequest(Request $request): ?ProductsCollectionRequestInterface
    {
        $category      = $request->get('category');
        $priceLessThan = $request->get('price_less_than');

        //ToDo check for not allowed query params and throw an exception

        $request = new ProductsCollectionRequest(
            limit: ProductsCollectionRequestMapperInterface::RESULTS_LIMIT,
            category: null !== $category ? trim($category) : null,
            priceLessThan: null !== $priceLessThan ? (int) $priceLessThan : null
        );

        $this->errors = $this->validator->validate($request);

        return $this->hasErrors() ? null : $request;
    }
}

<?php
/*
 * (c) Tzvetelin Tzvetkov <tzvetelin.tzvetkov@gmail.com>
 */

declare(strict_types=1);

namespace MT\Tests\Application\Rest\Request\Mapper;

use MT\Application\Interfaces\Rest\Request\Mapper\ProductsCollectionRequestMapperInterface;
use MT\Application\Interfaces\Rest\Request\ProductsCollectionRequestInterface;
use MT\Application\Rest\Request\Mapper\ProductsCollectionRequestMapper;
use MT\Tests\Mocked;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ProductsCollectionRequestMapperTest extends Mocked
{
    /**
     * @var ProductsCollectionRequestMapperInterface
     */
    private ProductsCollectionRequestMapperInterface $inTest;

    protected function setUp(): void
    {
        self::bootKernel();
        $container = self::getContainer();

        $this->inTest = new ProductsCollectionRequestMapper(
            $container->get(ValidatorInterface::class)
        );
    }

    public function testToProductsCollectionRequestMappingSuccessWithEmptyRequest(): void
    {
        $request = $this->inTest->toProductsCollectionRequest(
            request: new Request()
        );

        $this->assertFalse($this->inTest->hasErrors());
        $this->assertInstanceOf(ProductsCollectionRequestInterface::class, $request);
    }

    public function testToProductsCollectionRequestMappingSuccessWithAllNeededParams(): void
    {
        $request = $this->inTest->toProductsCollectionRequest(
            request: new Request([
                'category'        => 'test',
                'price_less_than' => '10000'
            ])
        );

        $this->assertFalse($this->inTest->hasErrors());
        $this->assertInstanceOf(ProductsCollectionRequestInterface::class, $request);
    }

    public function testToProductsCollectionRequestMappingFailed(): void
    {
        $request = $this->inTest->toProductsCollectionRequest(
            request: new Request([
                'category'        => '',
                'price_less_than' => '10000'
            ])
        );

        $this->assertTrue($this->inTest->hasErrors());
    }
}

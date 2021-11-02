<?php
/*
 * (c) Tzvetelin Tzvetkov <tzvetelin.tzvetkov@gmail.com>
 */

declare(strict_types=1);

namespace MT\Tests\Application\Rest\Request\Mapper;

use MT\Application\Interfaces\Rest\Response\Mapper\ProductWithDiscountResponseMapperInterface;
use MT\Application\Interfaces\Rest\Response\ProductWithDiscountResponseInterface;
use MT\Application\Rest\Response\Mapper\ProductWithDiscountResponseMapper;
use MT\Domain\Entity\Discount;
use MT\Domain\Entity\Product;
use MT\Domain\Interfaces\Handler\DiscountsHandlerInterface;
use MT\Tests\Mocked;
use stdClass;

class ProductWithDiscountResponseMapperTest extends Mocked
{
    /**
     * @var ProductWithDiscountResponseMapperInterface
     */
    private ProductWithDiscountResponseMapperInterface $inTest;

    protected function setUp(): void
    {
        self::bootKernel();
        $container = self::getContainer();

        $this->inTest = new ProductWithDiscountResponseMapper(
            $container->get(DiscountsHandlerInterface::class)
        );
    }

    public function testToProductWithDiscountResponseMappingSuccessWithEmptyDiscount(): void
    {
        $product = (new Product())
            ->setSku('000001')
            ->setName('Test')
            ->setCategory('boots')
            ->setPrice(7900);

        $price                      = new stdClass();
        $price->original            = $product->getPrice();
        $price->final               = $product->getPrice();
        $price->discount_percentage = null;
        $price->currency            = 'EUR';

        $response = $this->inTest->toProductWithDiscountResponse(
            product: $product,
            discount: null
        );

        $this->assertInstanceOf(ProductWithDiscountResponseInterface::class, $response);
        $this->assertEquals($product->getSku(), $response->getSku());
        $this->assertEquals($product->getName(), $response->getName());
        $this->assertEquals($product->getCategory(), $response->getCategory());
        $this->assertIsObject($response->getPrice());
        $this->assertEquals(json_encode($price), json_encode($response->getPrice()));
    }

    public function testToProductWithDiscountResponseMappingSuccessWithDiscount(): void
    {
        $product = (new Product())
            ->setSku('000001')
            ->setName('Test')
            ->setCategory('boots')
            ->setPrice(1000);

        $discount = (new Discount())
            ->setName('Test discount')
            ->setCondition(['sku' => '000001'])
            ->setDiscount(30);

        $price                      = new stdClass();
        $price->original            = $product->getPrice();
        $price->final               = 700;
        $price->discount_percentage = $discount->getDiscount();
        $price->currency            = 'EUR';

        $response = $this->inTest->toProductWithDiscountResponse(
            product: $product,
            discount: $discount
        );

        $this->assertInstanceOf(ProductWithDiscountResponseInterface::class, $response);
        $this->assertEquals($product->getSku(), $response->getSku());
        $this->assertEquals($product->getName(), $response->getName());
        $this->assertEquals($product->getCategory(), $response->getCategory());
        $this->assertIsObject($response->getPrice());
        $this->assertEquals(json_encode($price), json_encode($response->getPrice()));
    }
}

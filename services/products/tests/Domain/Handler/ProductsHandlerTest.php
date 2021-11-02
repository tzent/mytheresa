<?php
/*
 * (c) Tzvetelin Tzvetkov <tzvetelin.tzvetkov@gmail.com>
 */

declare(strict_types=1);

namespace MT\Test\Domain\Handler;

use MT\Application\Rest\Request\ProductsCollectionRequest;
use MT\Domain\Handler\DiscountsHandler;
use MT\Domain\Handler\ProductsHandler;
use MT\Domain\Interfaces\Handler\ProductsHandlerInterface;
use MT\Infrastructure\Repository\ProductsRepository;
use MT\Tests\Mocked;
use Symfony\Component\Serializer\SerializerInterface;

class ProductsHandlerTest extends Mocked
{
    /**
     * @var ProductsHandlerInterface
     */
    private ProductsHandlerInterface $inTest;

    protected function setUp(): void
    {
        self::bootKernel();
        $container = self::getContainer();

        $this->inTest = new ProductsHandler(
            new ProductsRepository(
                $container->get(SerializerInterface::class),
                $this->getProductsDbConnectionMock()
            ),
            new DiscountsHandler($this->getDiscountRepositoryMock())
        );
    }

    public function testSearchByCategory(): void
    {
        $category = 'boots';
        $limit    = 2;
        $request  = new ProductsCollectionRequest(limit: $limit, category: $category, priceLessThan: null);

        $result = $this->inTest->search($request);

        $this->assertNotEmpty($result);
        $this->assertIsArray($result);
        $this->assertCount($limit, $result);

        foreach ($result as $product) {
            $this->assertArrayHasKey('product', $product);
            $this->assertArrayHasKey('discount', $product);
            $this->assertEquals($category, $product['product']->getCategory());
        }
    }

    public function testSearchByCategoryAndPriceLessThan(): void
    {
        $category      = 'boots';
        $priceLessThan = 71000;
        $request       = new ProductsCollectionRequest(limit: 3, category: $category, priceLessThan: $priceLessThan);

        $result = $this->inTest->search($request);

        $this->assertNotEmpty($result);
        $this->assertIsArray($result);

        foreach ($result as $product) {
            $this->assertArrayHasKey('product', $product);
            $this->assertArrayHasKey('discount', $product);
            $this->assertEquals($category, $product['product']->getCategory());
            $this->assertLessThan($priceLessThan, $product['product']->getPrice());
        }
    }

    public function testSearchEmptyResult(): void
    {
        $category = 'tttt';
        $request  = new ProductsCollectionRequest(limit: null, category: $category, priceLessThan: null);

        $result = $this->inTest->search($request);

        $this->assertEmpty($result);
    }
}

<?php
/*
 * (c) Tzvetelin Tzvetkov <tzvetelin.tzvetkov@gmail.com>
 */

declare(strict_types=1);

namespace MT\Test\Domain\Handler;

use MT\Domain\Entity\Discount;
use MT\Domain\Handler\DiscountsHandler;
use MT\Domain\Interfaces\Handler\DiscountsHandlerInterface;
use MT\Tests\Mocked;

class DiscountsHandlerTest extends Mocked
{
    /**
     * @var DiscountsHandlerInterface
     */
    private DiscountsHandlerInterface $inTest;

    protected function setUp(): void
    {
        self::bootKernel();

        $this->inTest = new DiscountsHandler(
            $this->getDiscountRepositoryMock()
        );
    }

    public function testDiscountNotFound(): void
    {
        $product  = $this->getProduct();
        $discount = $this->inTest->findDiscount($product);

        $this->assertEquals(null, $discount);
    }

    public function testDiscountApplied(): void
    {
        $product = $this->getProduct()->setSku('000003');

        $discount = $this->inTest->findDiscount($product);

        $this->assertInstanceOf(Discount::class, $discount);
    }

    public function testBiggerDiscountApplied(): void
    {
        $product = $this->getProduct()
            ->setCategory('boots')
            ->setSku('000003');

        $discount = $this->inTest->findDiscount($product);

        $this->assertInstanceOf(Discount::class, $discount);
        $this->assertEquals(30, $discount->getDiscount());
    }

    public function testCalculateDiscountPrice(): void
    {
        $result = $this->inTest->calculateDiscountPrice(1000, 30);

        $this->assertEquals(700, $result);
    }
}

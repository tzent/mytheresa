<?php
/*
 * (c) Tzvetelin Tzvetkov <tzvetelin.tzvetkov@gmail.com>
 */

declare(strict_types=1);

namespace MT\Tests;

use JsonMachine\JsonDecoder\PassThruDecoder;
use JsonMachine\JsonMachine;
use MT\Domain\Entity\Discount;
use MT\Domain\Entity\Product;
use MT\Infrastructure\Interfaces\Connection\ConnectionInterface;
use MT\Infrastructure\Interfaces\Repository\DiscountsRepositoryInterface;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

abstract class Mocked extends KernelTestCase
{
    /**
     * @return MockObject
     */
    public function getDiscountsDbConnectionMock(): MockObject
    {
        $connectionMock = $this->createMock(ConnectionInterface::class);
        $connectionMock
            ->expects($this->any())
            ->method('getRows')
            ->willReturn(JsonMachine::fromString(
                string: '{"discounts": [
                    {"name":"All products in category \"boost\" have 30% discount","condition": {"category": "boost"},"discount":30},
                    {"name":"Product whit sku \"000003\" has 15% discount","condition": {"sku": "000003"},"discount":15}
                    ]}',
                jsonPointer: '/discounts',
                jsonDecoder: new PassThruDecoder()
            ));

        return $connectionMock;
    }

    /**
     * @return MockObject
     */
    public function getProductsDbConnectionMock(): MockObject
    {
        $connectionMock = $this->createMock(ConnectionInterface::class);
        $connectionMock
            ->expects($this->any())
            ->method('getRows')
            ->willReturn(JsonMachine::fromString(
                string: '{"products": [
                    {"sku":"000001","name":"BV Lean leather ankle boots","category":"boots","price":89000},
                    {"sku":"000002","name":"BV Lean leather ankle boots","category":"boots","price":99000},
                    {"sku":"000003","name":"Ashlington leather ankle boots","category":"boots","price":71000},
                    {"sku":"000004","name":"Naima embellished suede sandals","category":"sandals","price":79500},
                    {"sku":"000005","name":"Nathane leather sneakers","category":"sneakers","price":59000},
                    {"sku":"000006","name":"Nathane leather sneakers","category":"boots","price":59000},
                    {"sku":"000007","name":"Nathane leather sneakers","category":"sneakers","price":59000},
                    {"sku":"000008","name":"Nathane leather sneakers","category":"sneakers","price":59000}
                    ]}',
                jsonPointer: '/products',
                jsonDecoder: new PassThruDecoder()
            ));

        return $connectionMock;
    }

    /**
     * @return MockObject
     */
    public function getDiscountRepositoryMock(): MockObject
    {
        $repositoryMock = $this->createMock(DiscountsRepositoryInterface::class);
        $repositoryMock
            ->expects($this->any())
            ->method('findBy')
            ->willReturn([
                (new Discount())
                    ->setName(name: 'All products in category "boots" have 30% discount')
                    ->setCondition(condition: ['category' => 'boots'])
                    ->setDiscount(discount: 30),
                (new Discount())
                    ->setName(name: 'Product whit sku "000003" has 15% discount')
                    ->setCondition(condition: ['sku' => '000003'])
                    ->setDiscount(discount: 15)
            ]);

        return $repositoryMock;
    }

    /**
     * @return Product
     */
    public function getProduct(): Product
    {
        return (new Product())
            ->setName('Product name')
            ->setSku('000100')
            ->setCategory('test')
            ->setPrice(1000);
    }
}

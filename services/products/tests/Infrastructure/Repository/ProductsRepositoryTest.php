<?php
/*
 * (c) Tzvetelin Tzvetkov <tzvetelin.tzvetkov@gmail.com>
 */

declare(strict_types=1);

namespace MT\Tests\Infrastructure\Repository;

use MT\Infrastructure\Interfaces\Repository\ProductsRepositoryInterface;
use MT\Infrastructure\Repository\ProductsRepository;
use MT\Tests\Mocked;
use Symfony\Component\Serializer\SerializerInterface;

class ProductsRepositoryTest extends Mocked
{
    /**
     * @var ProductsRepositoryInterface
     */
    private ProductsRepositoryInterface $inTest;

    protected function setUp(): void
    {
        self::bootKernel();
        $container = static::getContainer();

        $this->inTest = new ProductsRepository(
            $container->get(SerializerInterface::class),
            $this->getProductsDbConnectionMock()
        );
    }

    public function testFindByWithLimit(): void
    {
        $limit  = 3;
        $result = $this->inTest->findBy(null, ['limit' => $limit]);

        $this->assertNotEmpty($result);
        $this->assertCount($limit, $result);
    }

    /**
     * @return array
     */
    public function criteriaProvider(): array
    {
        return [
            'empty criteria'                         => [[], 8],
            'search by category'                     => [['category' => 'boots'], 4],
            'search by price less than'              => [['priceLessThan' => 79500], 5],
            'search by category and price less than' => [['category' => 'boots', 'priceLessThan' => 79500], 2],
        ];
    }

    /**
     * @dataProvider criteriaProvider
     * @param array $criteria
     * @param $counts
     */
    public function testFindByWithCriteria(array $criteria, $counts): void
    {
        $result = $this->inTest->findBy($criteria);

        $this->assertNotEmpty($result);
        $this->assertCount($counts, $result);
    }
}

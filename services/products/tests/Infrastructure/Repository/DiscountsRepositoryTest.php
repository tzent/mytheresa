<?php
/*
 * (c) Tzvetelin Tzvetkov <tzvetelin.tzvetkov@gmail.com>
 */

declare(strict_types=1);

namespace MT\Tests\Infrastructure\Repository;

use MT\Infrastructure\Repository\DiscountsRepository;
use MT\Tests\Mocked;
use Symfony\Component\Serializer\SerializerInterface;

class DiscountsRepositoryTest extends Mocked
{
    /**
     * @var DiscountsRepository
     */
    private DiscountsRepository $inTest;

    protected function setUp(): void
    {
        self::bootKernel();
        $container = static::getContainer();

        $this->inTest = new DiscountsRepository(
            $container->get(SerializerInterface::class),
            $this->getDiscountsDbConnectionMock()
        );
    }

    public function testFindByWithLimit(): void
    {
        $limit  = 1;
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
            'empty criteria'     => [[], 2],
            'search by discount' => [['discount' => 30], 1],
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

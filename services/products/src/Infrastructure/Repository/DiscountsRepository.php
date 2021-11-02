<?php
/*
 * (c) Tzvetelin Tzvetkov <tzvetelin.tzvetkov@gmail.com>
 */

declare(strict_types=1);

namespace MT\Infrastructure\Repository;

use MT\Domain\Entity\Discount;
use MT\Infrastructure\Interfaces\Connection\ConnectionInterface;
use MT\Infrastructure\Interfaces\Repository\DiscountsRepositoryInterface;
use Symfony\Component\Serializer\SerializerInterface;

final class DiscountsRepository extends AbstractRepository implements DiscountsRepositoryInterface
{
    private const TABLE = 'discounts';

    /**
     * @param SerializerInterface $serializer
     * @param ConnectionInterface $connection
     */
    public function __construct(
        SerializerInterface $serializer,
        ConnectionInterface $connection
    ) {
        parent::__construct($serializer, $connection);
        $this->entity = Discount::class;
    }

    /**
     * @param  array|null $criteria
     * @param  array|null $options
     * @return array
     */
    public function findBy(?array $criteria = null, ?array $options = null): array
    {
        return $this->query(DiscountsRepository::TABLE, $criteria, $options);
    }
}

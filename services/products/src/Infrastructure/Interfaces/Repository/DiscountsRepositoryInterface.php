<?php
/*
 * (c) Tzvetelin Tzvetkov <tzvetelin.tzvetkov@gmail.com>
 */

declare(strict_types=1);

namespace MT\Infrastructure\Interfaces\Repository;

interface DiscountsRepositoryInterface
{
    /**
     * @param  array|null $criteria
     * @param  array|null $options
     * @return array
     */
    public function findBy(?array $criteria = null, ?array $options = null): array;
}

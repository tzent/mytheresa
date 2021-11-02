<?php
/*
 * (c) Tzvetelin Tzvetkov <tzvetelin.tzvetkov@gmail.com>
 */

declare(strict_types=1);

namespace MT\Infrastructure\Repository;

use MT\Infrastructure\Enum\CriteriaConditions;
use MT\Infrastructure\Enum\CriteriaOperators;
use MT\Infrastructure\Interfaces\Connection\ConnectionInterface;
use Symfony\Component\Serializer\SerializerInterface;

class AbstractRepository
{
    /**
     * @var SerializerInterface
     */
    protected SerializerInterface $serializer;

    /**
     * @var ConnectionInterface
     */
    protected ConnectionInterface $connection;

    /**
     * @var string
     */
    protected string $entity;

    public function __construct(
        SerializerInterface $serializer,
        ConnectionInterface $connection
    ) {
        $this->serializer = $serializer;
        $this->connection = $connection;
    }

    /**
     * @param  string     $table
     * @param  array|null $criteria
     * @param  array|null $options
     * @return array
     */
    protected function query(string $table, ?array $criteria, ?array $options): array
    {
        $result                         = [];
        null !== $criteria && $criteria = $this->filter($criteria);
        null !== $options && $options   = $this->filter($options);

        $count = 0;
        foreach ($this->connection->getRows(table: $table) as $row) {
            $current = $this->serializer->deserialize(
                is_string($row)
                    ? $row
                    : $this->serializer->serialize($row, 'json'),
                $this->entity,
                'json');

            if ($this->check($current, $criteria)) {
                $result[] = $current;
                $count++;
            }

            if (!empty($options['limit']) && $count === $options['limit']) {
                break;
            }
        }

        return $result;
    }

    /**
     * @param  object     $product
     * @param  array|null $criteria
     * @return bool
     */
    protected function check(object $product, ?array $criteria): bool
    {
        // ToDo move all criteria logic in separated module
        if (empty($criteria)) {
            return true;
        }

        foreach ($criteria as $field => $condition) {
            $operator = CriteriaOperators::EQUAL;

            if (strpos($field, CriteriaConditions::LESS_THAN, -(strlen(CriteriaConditions::LESS_THAN))) !== false) {
                $operator = CriteriaOperators::LESS_THAN;
                $field    = substr($field, 0, strlen($field) - strlen(CriteriaConditions::LESS_THAN));
            }

            // check if needed class property exists
            if (!property_exists($this->entity, $field)) {
                throw new \InvalidArgumentException(sprintf(
                    'Field %s does not exist in class %s', $field, $this->entity
                ));
            }

            switch ($operator) {
                case CriteriaOperators::EQUAL:
                    if ($product->{$field} != $condition) {
                        return false;
                    }
                    break;
                case CriteriaOperators::LESS_THAN:
                    if ($product->{$field} >= $condition) {
                        return false;
                    }
                    break;
                default:
                    throw new \InvalidArgumentException(sprintf('Invalid operator %s', $operator));
            }
        }

        return true;
    }

    /**
     * @param  array|null $params
     * @return array|null
     */
    private function filter(?array $params): ?array
    {
        return array_filter($params, function ($element) {
            return null !== $element;
        });
    }
}

<?php
/*
 * (c) Tzvetelin Tzvetkov <tzvetelin.tzvetkov@gmail.com>
 */

declare(strict_types=1);

namespace MT\Application\Rest\Request;

use MT\Application\Interfaces\Rest\Request\ProductsCollectionRequestInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class ProductsCollectionRequest implements ProductsCollectionRequestInterface
{
    /**
     * @var string|null
     */
    #[Assert\NotBlank(allowNull: true)]
    #[Assert\Type(type: 'string')]
    private ?string $category;

    /**
     * @var int|null
     */
    #[Assert\NotBlank(allowNull: true)]
    #[Assert\Type(type: 'int')]
    #[Assert\PositiveOrZero]
    private ?int $priceLessThan;

    /**
     * @var int|null
     */
    #[Assert\Positive]
    private ?int $limit;

    public function __construct(?int $limit, ?string $category, ?int $priceLessThan)
    {
        $this->limit         = $limit;
        $this->category      = $category;
        $this->priceLessThan = $priceLessThan;
    }

    /**
     * @return string|null
     */
    public function getCategory(): ?string
    {
        return $this->category;
    }

    /**
     * @return int|null
     */
    public function getPriceLessThan(): ?int
    {
        return $this->priceLessThan;
    }

    /**
     * @return int|null
     */
    public function getLimit(): ?int
    {
        return $this->limit;
    }
}

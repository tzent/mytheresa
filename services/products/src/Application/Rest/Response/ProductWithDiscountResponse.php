<?php

namespace MT\Application\Rest\Response;

use MT\Application\Interfaces\Rest\Response\ProductWithDiscountResponseInterface;
use Symfony\Component\Serializer\Annotation\Groups;

class ProductWithDiscountResponse implements ProductWithDiscountResponseInterface
{
    /**
     * @var string
     */
    #[Groups(['collection'])]
    private string $sku;

    /**
     * @var string
     */
    #[Groups(['collection'])]
    private string $name;

    /**
     * @var string
     */
    #[Groups(['collection'])]
    private string $category;

    /**
     * @var object
     */
    #[Groups(['collection'])]
    private object $price;

    /**
     * @param string $sku
     * @param string $name
     * @param string $category
     * @param object $price
     */
    public function __construct(
        string $sku,
        string $name,
        string $category,
        object $price
    ) {
        $this->sku      = $sku;
        $this->name     = $name;
        $this->category = $category;
        $this->price    = $price;
    }

    /**
     * @return string
     */
    public function getSku(): string
    {
        return $this->sku;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getCategory(): string
    {
        return $this->category;
    }

    /**
     * @return object
     */
    public function getPrice(): object
    {
        return $this->price;
    }
}

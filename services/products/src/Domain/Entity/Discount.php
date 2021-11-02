<?php
/*
 * (c) Tzvetelin Tzvetkov <tzvetelin.tzvetkov@gmail.com>
 */

declare(strict_types=1);

namespace MT\Domain\Entity;

class Discount
{
    /**
     * @var string
     */
    private string $name;

    /**
     * @var array
     */
    private array $condition;

    /**
     * @var int
     */
    private int $discount;

    /**
     * @param $name
     * @return bool
     */
    public function __isset($name)
    {
        return property_exists($this, $name);
    }

    /**
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->{$name};
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param  string $name
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return array
     */
    public function getCondition(): array
    {
        return $this->condition;
    }

    /**
     * @param  array $condition
     * @return $this
     */
    public function setCondition(array $condition): self
    {
        $this->condition = $condition;

        return $this;
    }

    /**
     * @return int
     */
    public function getDiscount(): int
    {
        return $this->discount;
    }

    /**
     * @param  int   $discount
     * @return $this
     */
    public function setDiscount(int $discount): self
    {
        $this->discount = $discount;

        return $this;
    }
}

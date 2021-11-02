<?php
/*
 * (c) Tzvetelin Tzvetkov <tzvetelin.tzvetkov@gmail.com>
 */

declare(strict_types=1);

namespace MT\Application\Interfaces\Rest\Response;

interface ProductWithDiscountResponseInterface
{
    /**
     * @return string
     */
    public function getSku(): string;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return string
     */
    public function getCategory(): string;

    /**
     * @return object
     */
    public function getPrice(): object;
}

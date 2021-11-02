<?php
/*
 * (c) Tzvetelin Tzvetkov <tzvetelin.tzvetkov@gmail.com>
 */

declare(strict_types=1);

namespace MT\Application\Interfaces\Rest\Request;

interface ProductsCollectionRequestInterface
{
    /**
     * @return string|null
     */
    public function getCategory(): ?string;

    /**
     * @return int|null
     */
    public function getPriceLessThan(): ?int;

    /**
     * @return int|null
     */
    public function getLimit(): ?int;
}

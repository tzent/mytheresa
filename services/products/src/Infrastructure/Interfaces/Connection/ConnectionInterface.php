<?php
/*
 * (c) Tzvetelin Tzvetkov <tzvetelin.tzvetkov@gmail.com>
 */

declare(strict_types=1);

namespace MT\Infrastructure\Interfaces\Connection;

use JsonMachine\JsonMachine;

interface ConnectionInterface
{
    /**
     * @param  string      $table
     * @return JsonMachine
     */
    public function getRows(string $table): JsonMachine;
}

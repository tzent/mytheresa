<?php
/*
 * (c) Tzvetelin Tzvetkov <tzvetelin.tzvetkov@gmail.com>
 */

declare(strict_types=1);

namespace MT\Infrastructure\Connection;

use JsonMachine\JsonDecoder\PassThruDecoder;
use JsonMachine\JsonMachine;
use LogicException;
use MT\Infrastructure\Interfaces\Connection\ConnectionInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;

final class Connection implements ConnectionInterface
{
    /**
     * @var string
     */
    private string $db;

    /**
     * @var ContainerBagInterface
     */
    private ContainerBagInterface $containerBag;

    /**
     * @param ContainerBagInterface $containerBag
     */
    public function __construct(
        ContainerBagInterface $containerBag
    ) {
        $this->containerBag = $containerBag;

        $this->db = $this->containerBag->get('products-db');
        if (!file_exists($this->db)) {
            throw new LogicException(sprintf('Data file %s does not exist', $this->db));
        }
    }

    /**
     * @param  string      $table
     * @return JsonMachine
     */
    public function getRows(string $table): JsonMachine
    {
        return JsonMachine::fromFile(
            file: $this->db,
            jsonPointer: sprintf('/%s', $table),
            jsonDecoder: new PassThruDecoder()
        );
    }
}

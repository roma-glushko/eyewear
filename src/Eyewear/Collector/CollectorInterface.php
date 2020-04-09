<?php

declare(strict_types=1);

namespace Eyewear\Collector;

use PDO;

/**
 *
 */
interface CollectorInterface
{
    /**
     * @param PDO $connection
     *
     * @return array
     */
    public function collect(PDO $connection): array;
}
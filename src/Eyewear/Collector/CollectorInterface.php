<?php

declare(strict_types=1);

namespace Eyewear\Collector;

use PDO;

/**
 *
 */
interface CollectorInterface
{
    public function collect(PDO $connection): array;
}
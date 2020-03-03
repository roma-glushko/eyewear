<?php

declare(strict_types=1);

namespace Eyewear\Collector;

use Generator;

/**
 *
 */
class CollectorManager
{
    /**
     * @var string[]
     */
    private $collectors;

    /**
     * CollectorManager constructor.
     */
    public function __construct()
    {
        $this->collectors = [
            CatalogProductTypeCountCollector::class,
            CatalogProductTypeCountCollector::class,
        ];
    }

    /**
     * @return Generator|CollectorInterface
     */
    public function getCollectors(): Generator
    {
        foreach ($this->collectors as $collectorClass) {
            yield (new $collectorClass);
        }
    }
}
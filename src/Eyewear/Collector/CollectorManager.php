<?php

declare(strict_types=1);

namespace Eyewear\Collector;

use Eyewear\Collector\Catalog\ProductCountCollector;
use Eyewear\Collector\Catalog\ProductTypeCountCollector;
use Eyewear\Collector\Customer\CustomerGroupCountCollector;
use Eyewear\Collector\Schema\SchemaSizeCollector;
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
            ProductCountCollector::class,
            ProductTypeCountCollector::class,
            CustomerGroupCountCollector::class,
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
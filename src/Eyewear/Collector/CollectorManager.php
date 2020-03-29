<?php

declare(strict_types=1);

namespace Eyewear\Collector;

use Eyewear\Collector\CartRule\CartRuleCountCollector;
use Eyewear\Collector\Catalog\ProductCountCollector;
use Eyewear\Collector\Catalog\ProductTypeCountCollector;
use Eyewear\Collector\Config\ConfigCountCollector;
use Eyewear\Collector\Config\ConfigGroupCountCollector;
use Eyewear\Collector\Customer\CustomerCountCollector;
use Eyewear\Collector\Customer\CustomerGroupCountCollector;
use Eyewear\Collector\Customer\CustomerOrderCollector;
use Eyewear\Collector\Eav\AttributeBySetCountCollector;
use Eyewear\Collector\Eav\AttributeCountCollector;
use Eyewear\Collector\Eav\AttributeEntityCountCollector;
use Eyewear\Collector\Eav\AttributeSetCountCollector;
use Eyewear\Collector\Sales\OrderByStateCountCollector;
use Eyewear\Collector\Sales\OrderCountCollector;
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
            AttributeCountCollector::class,
            AttributeEntityCountCollector::class,
            AttributeSetCountCollector::class,
            AttributeBySetCountCollector::class,

            ProductCountCollector::class,
            ProductTypeCountCollector::class,

            CustomerCountCollector::class,
            CustomerGroupCountCollector::class,
            CustomerOrderCollector::class,

            CartRuleCountCollector::class,

            OrderCountCollector::class,
            OrderByStateCountCollector::class,

            ConfigCountCollector::class,
            ConfigGroupCountCollector::class,
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
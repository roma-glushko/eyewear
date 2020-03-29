<?php

declare(strict_types=1);

namespace Eyewear\Collector\Eav;

use Eyewear\Collector\CollectorInterface;
use PDO;

/**
 *
 */
class AttributeSetCountCollector implements CollectorInterface
{
    /**
     * @param PDO $connection
     *
     * @return array
     */
    public function collect(PDO $connection): array
    {
        $attributeSetCount = $connection->query(
            'SELECT COUNT(*) FROM `eav_attribute_set`'
        )->fetchColumn();

        return [
            'eav' => [
                'all-attribute-set-count' => (int) $attributeSetCount,
            ],
        ];
    }
}
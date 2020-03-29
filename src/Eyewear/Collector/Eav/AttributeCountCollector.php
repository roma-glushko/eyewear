<?php

declare(strict_types=1);

namespace Eyewear\Collector\Eav;

use Eyewear\Collector\CollectorInterface;
use PDO;

/**
 *
 */
class AttributeCountCollector implements CollectorInterface
{
    /**
     * @param PDO $connection
     *
     * @return array
     */
    public function collect(PDO $connection): array
    {
        $attributeCount = $connection->query(
            'SELECT COUNT(*) FROM `eav_attribute`'
        )->fetchColumn();

        $withoutSetsList = $connection->query(
            'SELECT attribute_code 
             FROM `eav_attribute` 
             WHERE attribute_id NOT IN (SELECT DISTINCT attribute_id FROM eav_entity_attribute)'
        )->fetchAll(PDO::FETCH_COLUMN);

        return [
            'eav' => [
                'all-attribute-count' => $attributeCount,
                'attributes-without-set' => $withoutSetsList,
            ],
        ];
    }
}
<?php

declare(strict_types=1);

namespace Eyewear\Collector\Eav;

use Eyewear\Collector\CollectorInterface;
use PDO;

/**
 *
 */
class AttributeBySetCountCollector implements CollectorInterface
{
    /**
     * @param PDO $connection
     *
     * @return array
     */
    public function collect(PDO $connection): array
    {
        $attributeBySetCounts = $connection->query(
            'SELECT entity_type_code as "group_code", attribute_set_name as "set", COUNT(*) as "count"
            FROM `eav_entity_attribute`
            LEFT JOIN `eav_entity_type` ON eav_entity_type.entity_type_id=eav_entity_attribute.entity_type_id
            LEFT JOIN `eav_attribute_set` ON eav_attribute_set.attribute_set_id=eav_entity_attribute.attribute_set_id
            GROUP BY eav_entity_attribute.entity_type_id, eav_entity_attribute.attribute_set_id'
        )->fetchAll(PDO::FETCH_ASSOC);

        $types = [];

        foreach ($attributeBySetCounts as $attributeBySetCount) {
            $types[$attributeBySetCount['group_code']][] = [
                'set' => $attributeBySetCount['set'],
                'count' => (int) $attributeBySetCount['count'],
            ];
        }

        return [
            'eav' => [
                'attributes-by-set' => $types,
            ],
        ];
    }
}
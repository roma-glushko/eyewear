<?php

declare(strict_types=1);

namespace Eyewear\Collector\Eav;

use Eyewear\Collector\CollectorInterface;
use PDO;

/**
 *
 */
class AttributeEntityCountCollector implements CollectorInterface
{
    /**
     * @param PDO $connection
     *
     * @return array
     */
    public function collect(PDO $connection): array
    {
        $attributeEntityTypeCounts = $connection->query(
            'SELECT entity_type_code as group_code, COUNT(*) as count FROM eav_attribute
             LEFT JOIN eav_entity_type ON eav_attribute.entity_type_id=eav_entity_type.entity_type_id
             GROUP BY entity_type_code
             ORDER BY entity_type_code'
        )->fetchAll(PDO::FETCH_ASSOC);

        $types = [];

        foreach ($attributeEntityTypeCounts as $attributeEntityTypeCount) {
            $types[$attributeEntityTypeCount['group_code']] = (int) $attributeEntityTypeCount['count'];
        }

        return [
            'eav' => [
                'attributes-by-entity-types' => $types,
            ],
        ];
    }
}
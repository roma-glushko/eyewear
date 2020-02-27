<?php

declare(strict_types=1);

namespace Eyewear\Collector;

use PDO;

/**
 *
 */
class CatalogProductTypeCountCollector implements CollectorInterface
{
    /**
     * @param PDO $connection
     *
     * @return array
     */
    public function collect(PDO $connection): array
    {
        $productTypeGroups = $connection->query(
            'SELECT type_id, COUNT(DISTINCT entity_id) as count 
            FROM catalog_product_entity 
            GROUP BY type_id'
        )->fetchAll(PDO::FETCH_ASSOC);

        $types = [];

        foreach ($productTypeGroups as $typeGroup) {
            $types[$typeGroup['type_id']] = $typeGroup['count'];
        }

        return [
            'catalog-product' => [
                'types' => $types,
            ],
        ];
    }
}
<?php

declare(strict_types=1);

namespace Eyewear\Collector\Catalog;

use Eyewear\Collector\CollectorInterface;
use PDO;

/**
 *
 */
class ProductTypeCountCollector implements CollectorInterface
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
            $types[$typeGroup['type_id']] = (int) $typeGroup['count'];
        }

        return [
            'catalog-products' => [
                'product-types' => $types,
            ],
        ];
    }
}
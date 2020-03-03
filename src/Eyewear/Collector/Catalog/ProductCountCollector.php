<?php

declare(strict_types=1);

namespace Eyewear\Collector\Catalog;

use Eyewear\Collector\CollectorInterface;
use PDO;

/**
 *
 */
class ProductCountCollector implements CollectorInterface
{
    /**
     * @param PDO $connection
     *
     * @return array
     */
    public function collect(PDO $connection): array
    {
        $statusId = $this->getProductStatusId($connection);

        $allProductCount = $connection->query(
            'SELECT COUNT(DISTINCT entity_id) FROM catalog_product_entity'
        )->fetchColumn();

        $enabledProductCount = $this->getProductStatsByStatus($connection, $statusId, '1');
        $disabledProductCount = $this->getProductStatsByStatus($connection, $statusId, '2');

        return [
            'catalog-product' => [
                'all-product-count' => $allProductCount,
                'enabled-product-count' => $enabledProductCount,
                'disabled-product-count' => $disabledProductCount,
            ],
        ];
    }

    /**
     * @param PDO $connection
     *
     * @return int
     */
    private function getProductStatusId(PDO $connection): int
    {
        return (int) $connection->query(
            'SELECT attribute_id FROM eav_attribute WHERE entity_type_id = 4 AND attribute_code = "status"'
        )->fetchColumn();
    }

    /**
     * @param PDO $connection
     * @param int $statusId
     * @param string $statusValueId
     *
     * @return int
     */
    private function getProductStatsByStatus(PDO $connection, int $statusId, string $statusValueId): int
    {
        $enabledProductStmt = $connection->prepare(
            'SELECT COUNT(DISTINCT entity_id) FROM catalog_product_entity
            LEFT JOIN catalog_product_entity_int ON 
                catalog_product_entity.row_id = catalog_product_entity_int.row_id AND attribute_id = :status_id
			WHERE catalog_product_entity_int.value = :status_value_id'
        );
        $enabledProductStmt->bindValue('status_id', $statusId);
        $enabledProductStmt->bindValue('status_value_id', $statusValueId);
        $enabledProductStmt->execute();

        return (int) $enabledProductStmt->fetchColumn();
    }
}
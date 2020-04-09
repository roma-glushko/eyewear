<?php

declare(strict_types=1);

namespace Eyewear\Collector\Catalog;

use Eyewear\Collector\CollectorInterface;
use Eyewear\Magento\Edition\EditionAwareInterface;
use Eyewear\Magento\Edition\EditionTrait;
use PDO;

/**
 *
 */
class ProductCountCollector implements CollectorInterface, EditionAwareInterface
{
    use EditionTrait;

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
            'catalog-products' => [
                'all-product-count' => (int) $allProductCount,
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
    private function getProductStatsByStatus(
        PDO $connection,
        int $statusId,
        string $statusValueId
    ): int {
        $edition = $this->getEdition();

        $productStmt = $connection->prepare(
            'SELECT COUNT(DISTINCT entity_id) FROM catalog_product_entity
            LEFT JOIN catalog_product_entity_int ON 
                catalog_product_entity.:link_field = catalog_product_entity_int.:link_field AND attribute_id = :status_id
			WHERE catalog_product_entity_int.value = :status_value_id'
        );

        $productStmt->bindValue('status_id', $statusId);
        $productStmt->bindValue('status_value_id', $statusValueId);
        $productStmt->bindValue('link_field', $edition->getLinkField());
        $productStmt->execute();

        return (int) $productStmt->fetchColumn();
    }
}
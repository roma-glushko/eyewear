<?php

declare(strict_types=1);

namespace Eyewear\Collector\Sales;

use Eyewear\Collector\CollectorInterface;
use PDO;

/**
 *
 */
class OrderCountCollector implements CollectorInterface
{
    /**
     * @param PDO $connection
     *
     * @return array
     */
    public function collect(PDO $connection): array
    {
        $allOrderCount = $connection->query(
            'SELECT COUNT(*) FROM sales_order'
        )->fetchColumn();

        $guestOrderCount = $connection->query(
            'SELECT COUNT(*) FROM sales_order WHERE customer_id IS NULL'
        )->fetchColumn();

        $customerOrderCount = $connection->query(
            'SELECT COUNT(*) FROM sales_order WHERE customer_id IS NOT NULL'
        )->fetchColumn();

        return [
            'orders' => [
                'all-order-count' => (int) $allOrderCount,
                'all-guest-order-count' => (int) $guestOrderCount,
                'all-customer-order-count' => (int) $customerOrderCount,
            ],
        ];
    }
}
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

        $maxOrderCountPerCustomers = $connection->query(
            'SELECT MAX(count) FROM (SELECT COUNT(*) as count FROM sales_order GROUP BY customer_email) orders'
        )->fetchColumn();

        return [
            'orders' => [
                'all-order-count' => (int) $allOrderCount,
                'count-by-guests' => (int) $guestOrderCount,
                'count-by-customers' => (int) $customerOrderCount,
                'max-count-by-customer' => (int) $maxOrderCountPerCustomers,
            ],
        ];
    }
}
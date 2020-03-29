<?php

declare(strict_types=1);

namespace Eyewear\Collector\Customer;

use Eyewear\Collector\CollectorInterface;
use PDO;

/**
 *
 */
class CustomerOrderCollector implements CollectorInterface
{
    /**
     * @param PDO $connection
     *
     * @return array
     */
    public function collect(PDO $connection): array
    {
        $atLeastOneOrderCount = $connection->query(
            'SELECT COUNT(*) 
             FROM customer_entity 
             WHERE email IN (SELECT customer_email FROM sales_order WHERE customer_email IS NOT NULL)'
        )->fetchColumn();

        $atLeastOneCompleteOrderCount = $connection->query(
            'SELECT COUNT(*) 
             FROM customer_entity 
             WHERE email IN (
                SELECT customer_email FROM sales_order WHERE customer_email IS NOT NULL and state = "complete"
             )'
        )->fetchColumn();

        $withoutOrders = $connection->query(
            'SELECT COUNT(*) 
             FROM customer_entity 
             WHERE email NOT IN (SELECT customer_email FROM sales_order WHERE customer_email IS NOT NULL)'
        )->fetchColumn();

        return [
            'customers' => [
                'with-at-least-one-order' => (int) $atLeastOneOrderCount,
                'with-at-least-one-complete-order' => (int) $atLeastOneCompleteOrderCount,
                'without-orders' => (int) $withoutOrders,
            ],
        ];
    }
}
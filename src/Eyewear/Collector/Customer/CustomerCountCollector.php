<?php

declare(strict_types=1);

namespace Eyewear\Collector\Customer;

use Eyewear\Collector\CollectorInterface;
use PDO;

/**
 *
 */
class CustomerCountCollector implements CollectorInterface
{
    /**
     * @param PDO $connection
     *
     * @return array
     */
    public function collect(PDO $connection): array
    {
        $allCustomerCount = $connection->query(
            'SELECT COUNT(*) FROM customer_entity'
        )->fetchColumn();

        return [
            'customers' => [
                'all-customer-count' => (int) $allCustomerCount,
            ],
        ];
    }
}
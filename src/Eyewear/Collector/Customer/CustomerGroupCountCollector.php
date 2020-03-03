<?php

declare(strict_types=1);

namespace Eyewear\Collector\Customer;

use Eyewear\Collector\CollectorInterface;
use PDO;

/**
 *
 */
class CustomerGroupCountCollector implements CollectorInterface
{
    /**
     * @param PDO $connection
     *
     * @return array
     */
    public function collect(PDO $connection): array
    {
        $customerGroupCounts = $connection->query(
            'SELECT group_id, COUNT(DISTINCT entity_id) as count 
            FROM customer_entity 
            GROUP BY group_id'
        )->fetchAll(PDO::FETCH_ASSOC);

        $types = [];

        foreach ($customerGroupCounts as $customerGroupCount) {
            $types[$customerGroupCount['group_id']] = $customerGroupCount['count'];
        }

        return [
            'customer' => [
                'customers-in-groups' => $types,
            ],
        ];
    }
}
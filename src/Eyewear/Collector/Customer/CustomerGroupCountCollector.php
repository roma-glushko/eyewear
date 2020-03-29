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
            'SELECT customer_group_code as group_code, COUNT(DISTINCT entity_id) as count 
            FROM customer_entity 
            LEFT JOIN customer_group ON customer_group.customer_group_id=customer_entity.group_id
            GROUP BY group_id'
        )->fetchAll(PDO::FETCH_ASSOC);

        $types = [];

        foreach ($customerGroupCounts as $customerGroupCount) {
            $types[$customerGroupCount['group_code']] = (int) $customerGroupCount['count'];
        }

        return [
            'customers' => [
                'customers-in-groups' => $types,
            ],
        ];
    }
}
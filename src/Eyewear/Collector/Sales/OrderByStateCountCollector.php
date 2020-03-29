<?php

declare(strict_types=1);

namespace Eyewear\Collector\Sales;

use Eyewear\Collector\CollectorInterface;
use PDO;

/**
 *
 */
class OrderByStateCountCollector implements CollectorInterface
{
    /**
     * @param PDO $connection
     *
     * @return array
     */
    public function collect(PDO $connection): array
    {
        $orderStateGroups = $connection->query(
            'SELECT state, COUNT(*) as count FROM sales_order GROUP BY state'
        )->fetchAll(PDO::FETCH_ASSOC);

        $groups = [];

        foreach ($orderStateGroups as $typeGroup) {
            $groups[$typeGroup['state']] = (int) $typeGroup['count'];
        }

        return [
            'orders' => [
                'order-state-groups' => $groups,
            ],
        ];
    }
}
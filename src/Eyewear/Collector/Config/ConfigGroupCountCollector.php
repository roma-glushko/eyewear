<?php

declare(strict_types=1);

namespace Eyewear\Collector\Config;

use Eyewear\Collector\CollectorInterface;
use PDO;

/**
 *
 */
class ConfigGroupCountCollector implements CollectorInterface
{
    /**
     * @param PDO $connection
     *
     * @return array
     */
    public function collect(PDO $connection): array
    {
        $configGroupCounts = $connection->query(
            'SELECT SUBSTRING_INDEX(path, "/", 1) as config_group, COUNT(DISTINCT path) as count 
            FROM core_config_data 
            GROUP BY config_group
            ORDER BY config_group'
        )->fetchAll(PDO::FETCH_ASSOC);

        $types = [];

        foreach ($configGroupCounts as $configGroupCount) {
            $types[$configGroupCount['config_group']] = (int) $configGroupCount['count'];
        }

        return [
            'configs' => [
                'config-groups' => $types,
            ],
        ];
    }
}
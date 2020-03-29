<?php

declare(strict_types=1);

namespace Eyewear\Collector\Config;

use Eyewear\Collector\CollectorInterface;
use PDO;

/**
 *
 */
class ConfigCountCollector implements CollectorInterface
{
    /**
     * @param PDO $connection
     *
     * @return array
     */
    public function collect(PDO $connection): array
    {
        $allConfigCount = $connection->query(
            'SELECT COUNT(*) FROM core_config_data'
        )->fetchColumn();

        return [
            'configs' => [
                'all-config-count' => (int) $allConfigCount,
            ],
        ];
    }
}
<?php

declare(strict_types=1);

namespace Eyewear\Collector\Schema;

use PDO;

/**
 *
 */
class SchemaSizeCollector
{
    /**
     * @param PDO $connection
     * @param string $databaseName
     *
     * @return array
     */
    public function collect(PDO $connection, string $databaseName): array
    {
         $schemaSizeStatement = $connection->prepare(
            'SELECT 
                table_name AS "table",
                ROUND(((data_length + index_length) / 1024 / 1024), 2) AS "overall",
                ROUND((data_length / 1024 / 1024), 2) as "data_size",
                ROUND((index_length / 1024 / 1024), 2) as "index_size"
            FROM information_schema.TABLES
            WHERE table_schema = :database
            ORDER BY (data_length + index_length) DESC'
        );
        $schemaSizeStatement->execute([
            ":database" => $databaseName
        ]);

        $schemaSizes = $schemaSizeStatement->fetchAll(PDO::FETCH_ASSOC);

        $types = [];

        foreach ($schemaSizes as $schemaSize) {
            $types[$schemaSize['table']] = [
                'overall' => $schemaSize['overall'] . 'Mb',
                'data_size' => $schemaSize['data_size'] . 'Mb',
                'index_size' => $schemaSize['index_size'] . 'Mb',
            ];
        }

        return [
            'schema' => [
                'schema-size' => $types,
            ],
        ];
    }
}
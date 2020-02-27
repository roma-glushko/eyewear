<?php

declare(strict_types=1);

namespace Eyewear\Database;

use PDO;

/**
 *
 */
class ConnectionFactory
{
    /**
     * @param string $host
     * @param string|null $port
     * @param string $user
     * @param string $password
     * @param string $database
     * @param array $options
     *
     * @return PDO
     */
    public static function create(
        string $user,
        string $password,
        string $database,
        string $host = 'localhost',
        string $port='3306',
        array $options = []
    ): PDO {
        $dns = sprintf(
            'mysql:host=%s;dbname=%s;port=%s',
            $host,
            $database,
            $port
        );

        return new PDO($dns, $user, $password, $options);
    }
}
<?php

declare(strict_types=1);

namespace Eyewear\Report;

use Exception;

/**
 *
 */
class JsonReport
{
    /**
     * @param string $filePath
     * @param array $metrics
     *
     * @throws Exception
     */
    public function save(string $filePath, array $metrics): void
    {
        file_put_contents(
            $filePath,
            json_encode($metrics, JSON_PRETTY_PRINT)
        );
    }
}
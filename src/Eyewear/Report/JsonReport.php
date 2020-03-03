<?php

declare(strict_types=1);

namespace Eyewear\Report;

/**
 *
 */
class JsonReport
{
    /**
     * @param array $metrics
     */
    public function save(array $metrics): void
    {
        file_put_contents(
            'eyewaer-db-report.timestamp.json',
            json_encode($metrics, JSON_PRETTY_PRINT)
        );
    }
}
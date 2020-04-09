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
     *
     * @throws \Exception
     */
    public function save(array $metrics): void
    {
        $timestamp = (new \DateTime())->getTimestamp();

        file_put_contents(
            sprintf('eyewear-db-report.%s.json', $timestamp),
            json_encode($metrics, JSON_PRETTY_PRINT)
        );
    }
}
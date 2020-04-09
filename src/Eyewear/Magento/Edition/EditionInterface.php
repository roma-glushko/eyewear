<?php

declare(strict_types=1);

namespace Eyewear\Magento\Edition;

/**
 *
 */
interface EditionInterface
{
    /**
     * Retrieve link field (entity_id/row_id)
     *
     * @return string
     */
    public function getLinkField(): string;
}
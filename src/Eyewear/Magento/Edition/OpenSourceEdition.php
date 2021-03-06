<?php

declare(strict_types=1);

namespace Eyewear\Magento\Edition;

/**
 *
 */
class OpenSourceEdition implements EditionInterface
{
    /**
     * @inheritDoc
     */
    public function getLinkField(): string
    {
        return 'entity_id';
    }
}
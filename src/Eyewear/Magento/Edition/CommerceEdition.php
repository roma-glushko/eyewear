<?php

declare(strict_types=1);

namespace Eyewear\Magento\Edition;

/**
 *
 */
class CommerceEdition implements EditionInterface
{
    /**
     * @inheritDoc
     */
    public function getLinkField(): string
    {
        return 'row_id';
    }
}
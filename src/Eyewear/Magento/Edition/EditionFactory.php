<?php

declare(strict_types=1);

namespace Eyewear\Magento\Edition;

use InvalidArgumentException;

/**
 *
 */
class EditionFactory
{
    /**
     * @param string $edition
     *
     * @return EditionInterface
     */
    public function create(string $edition): EditionInterface {
        if ('ce' === $edition) {
            return new OpenSourceEdition();
        }

        if ('ee' === $edition) {
            return new CommerceEdition();
        }

        throw new InvalidArgumentException('Unknown Magento Edition');
    }
}
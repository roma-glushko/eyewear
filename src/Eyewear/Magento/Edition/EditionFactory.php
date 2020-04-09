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
        if ($edition === 'ce') {
            return new OpenSourceEdition();
        }

        if ($edition === 'ee') {
            return new CommerceEdition();
        }

        throw new InvalidArgumentException('Unknown Magento Edition');
    }
}
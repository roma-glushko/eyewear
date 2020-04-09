<?php

declare(strict_types=1);

namespace Eyewear\Magento\Edition;

/**
 *
 */
interface EditionAwareInterface
{
    /**
     * @return EditionInterface
     */
    public function getEdition(): EditionInterface;

    /**
     * @param EditionInterface $edition
     */
    public function setEdition(EditionInterface $edition): void;
}
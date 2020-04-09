<?php

declare(strict_types=1);

namespace Eyewear\Magento\Edition;

/**
 *
 */
trait EditionTrait
{
    /**
     * @var EditionInterface
     */
    private $edition;

    /**
     * @return EditionInterface
     */
    public function getEdition(): EditionInterface
    {
        return $this->edition;
    }

    /**
     * @param EditionInterface $edition
     */
    public function setEdition(EditionInterface $edition): void
    {
        $this->edition = $edition;
    }
}
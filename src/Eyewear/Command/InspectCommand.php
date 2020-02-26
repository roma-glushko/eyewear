<?php

declare(strict_types=1);

namespace Eyewear\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Inspect Magento2 database
 */
class InspectCommand extends Command
{
    /**
     * Command Config
     */
    protected function configure()
    {
        parent::configure();

        $this->setName('inspect');
        $this->setDescription('Inspect Magento2 database');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        return 0;
    }
}
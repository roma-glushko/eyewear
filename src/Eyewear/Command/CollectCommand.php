<?php

declare(strict_types=1);

namespace Eyewear\Command;

use Eyewear\Collector\CatalogProductCountCollector;
use Eyewear\Collector\CatalogProductTypeCountCollector;
use Eyewear\Database\ConnectionFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Collect Magento2 database stats
 */
class CollectCommand extends Command
{
    /**
     * Command Config
     */
    protected function configure()
    {
        parent::configure();

        $this->setName('collect');
        $this->setDescription('Collects Magento2 database stats');

        $this->addOption('user', 'u', InputOption::VALUE_REQUIRED, 'Database User');
        $this->addOption('password', 'p', InputOption::VALUE_REQUIRED, 'Database Password');
        $this->addOption('database', 'd', InputOption::VALUE_REQUIRED, 'Database Name');
        $this->addOption('host', 'hst', InputOption::VALUE_OPTIONAL, 'Database Host', 'localhost');
        $this->addOption('port', 'prt', InputOption::VALUE_OPTIONAL, 'Database Port', '3306');
        $this->addOption('edition', 'e', InputOption::VALUE_OPTIONAL, 'Magento Edition', 'ce');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $user = $input->getOption('user');
        $password = $input->getOption('password');
        $database = $input->getOption('database');
        $host = $input->getOption('host');
        $port = $input->getOption('port');

        $connection = ConnectionFactory::create(
            $user,
            $password,
            $database,
            $host,
            $port
        );

        $stats = (new CatalogProductCountCollector())->collect($connection);
        $stats = (new CatalogProductTypeCountCollector())->collect($connection);

        var_dump($stats);

        return 0;
    }
}
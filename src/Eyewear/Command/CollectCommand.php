<?php

declare(strict_types=1);

namespace Eyewear\Command;

use DateTime;
use Exception;
use Eyewear\Collector\CollectorInterface;
use Eyewear\Collector\CollectorManager;
use Eyewear\Collector\Schema\SchemaSizeCollector;
use Eyewear\Database\ConnectionFactory;
use Eyewear\Magento\Edition\EditionFactory;
use Eyewear\Report\JsonReport;
use PDOException;
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
     * @var CollectorManager
     */
    private $collectorManager;

    /**
     * @var EditionFactory
     */
    private $editionFactory;

    public function __construct(string $name = null)
    {
        parent::__construct($name);

        $this->collectorManager = new CollectorManager();
        $this->editionFactory = new EditionFactory();
    }

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
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $user = $input->getOption('user');
        $password = $input->getOption('password');
        $database = $input->getOption('database');
        $host = $input->getOption('host');
        $port = $input->getOption('port');
        $editionCode = $input->getOption('edition');

        $this->collectorManager->setEdition(
            $this->editionFactory->create($editionCode)
        );

        $output->writeln(sprintf('🛠 Connecting to the database %s', $database));

        try {
            $connection = ConnectionFactory::create(
                $user,
                $password,
                $database,
                $host,
                $port
            );
        } catch(PDOException $ex){
            $output->writeln(sprintf('🛠 Cannot connect to the database: %s', $ex->getMessage()));

            return 1;
        }

        $output->writeln('🛠 Collecting database metrics');

        $databaseMetrics = [
            [
                'title' => 'Generated by Eyewear',
                'timestamp' => (new DateTime())->format(DateTime::ATOM),
            ]
        ];

        /** @var CollectorInterface $collector */
        foreach ($this->collectorManager->getCollectors() as $collector) {
            $databaseMetrics[] = $collector->collect($connection);
        }

        $databaseMetrics[] = (new SchemaSizeCollector())->collect($connection, $database);

        $databaseMetricMerged = array_merge_recursive(...$databaseMetrics);

        $output->writeln('📈 Generating a report..');

        (new JsonReport())->save($databaseMetricMerged);

        return 0;
    }
}
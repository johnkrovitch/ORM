<?php

namespace JohnKrovitch\ORMBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use JohnKrovitch\ORMBundle\Behavior\CommandBehavior;
use JohnKrovitch\ORMBundle\Manager\DriverManager;
use JohnKrovitch\ORMBundle\Manager\SchemaManager;
use JohnKrovitch\ORMBundle\Manager\SourceManager;


class SyncCommand extends ContainerAwareCommand
{
    use CommandBehavior;

    public function configure()
    {
        $this
            ->setName('orm:database:sync')
            ->setDescription('Synchronize database from various sources')
            ->addOption('source', 's', InputOption::VALUE_OPTIONAL, 'Allowed values: yml, database', 'yml')
            ->setHelp('Call your network administrator');
    }

    public function run(InputInterface $input, OutputInterface $output)
    {
        $output->writeln($this->getMemoryUsage());

        if (!($source = $input->hasOption('source'))) {
            $sources[] = 'yml';
        }
        // getting managers
        /** @var SourceManager $sourceManager */
        $sourceManager = $this->get('orm.manager.source');
        /** @var DriverManager $driverManager */
        $driverManager = $this->get('orm.manager.driver');
        /** @var SchemaManager $schemaManager */
        $schemaManager = $this->get('orm.manager.schema');

        // creating sources from options
        $this->writeInfo($output, $this->ormConsoleMarkup, ' Loading sources...');
        $sources = $sourceManager->createSourcesFromOptions($input->getOptions());

        // creating driver according to source type
        $this->writeInfo($output, $this->ormConsoleMarkup, ' Loading drivers...');
        $drivers = $driverManager->createDriversFromSources($sources);

        // loading drivers into schema manager
        $schemaManager->setDrivers($drivers);

        // loading schema into objects
        $this->writeInfo($output, $this->ormConsoleMarkup, ' Loading schema...');
        $schemaManager->load();

        // once the schema is loaded we synchronize it with the database
        $this->writeInfo($output, $this->ormConsoleMarkup, ' Synchronizing schema with database...');
        $schemaManager->synchronize();

        $output->writeln($this->getMemoryUsage());
    }
} 
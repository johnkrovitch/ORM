<?php

namespace JohnKrovitch\ORMBundle\Command;

use JohnKrovitch\ORMBundle\Behavior\CommandBehavior;
use JohnKrovitch\ORMBundle\Manager\DriverManager;
use JohnKrovitch\ORMBundle\Manager\SchemaManager;
use JohnKrovitch\ORMBundle\Manager\SourceManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class SyncCommand extends ContainerAwareCommand
{
    use CommandBehavior;

    public function configure()
    {
        $this
            ->setName('orm:database:sync')
            ->setDescription('Synchronize database from various sources')
            //->addOption('source', 's', InputOption::VALUE_OPTIONAL, 'Allowed values: yml, database', 'yml')
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

        // creating origin sources from options
        $this->writeInfo($output, $this->ormConsoleMarkup, ' Loading sources...');
        $originDataSources = $sourceManager->createSourcesFromOptions($input->getOptions());
        $destinationSources = $sourceManager->createSourcesFromOptions($this->getDatabaseParameters());

        // creating origin driver according to source type
        $this->writeInfo($output, $this->ormConsoleMarkup, ' Loading drivers...');
        $originDrivers = $driverManager->createDriversFromSources($originDataSources);
        $destinationDrivers = $driverManager->createDriversFromSources($destinationSources);

        // loading drivers into schema manager
        $schemaManager->setDrivers($originDrivers, $destinationDrivers);

        // loading schema into objects
        $this->writeInfo($output, $this->ormConsoleMarkup, ' Loading schema...');
        $schemaManager->load();

        // once the schema is loaded we synchronize it with the database
        $this->writeInfo($output, $this->ormConsoleMarkup, ' Synchronizing schema with database...');
        $schemaManager->synchronize();
        $this->writeInfo($output, $this->ormConsoleMarkup, ' Synchronization successful...');

        $output->writeln($this->getMemoryUsage());
    }

    /**
     * Return data for database connection from parameters.yml
     *
     * @return array
     */
    public function getDatabaseParameters()
    {
        $database = $this->getContainer()->getParameter('database');
        $host = $database['host'];
        $databaseDriver = $database['driver'];
        $name = $database['name'];
        $port = $database['port'];
        $login = $database['login'];
        $password = $database['password'];

        return [
            'type' => $databaseDriver,
            'MyDatabase' => [
                'host' => $host,
                'name' => $name,
                'login' => $login,
                'password' => $password,
                'port' => $port
            ]
        ];
    }
} 
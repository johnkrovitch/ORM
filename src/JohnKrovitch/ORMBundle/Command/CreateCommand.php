<?php

namespace JohnKrovitch\ORMBundle\Command;

use JohnKrovitch\ORMBundle\Database\Schema\SchemaLoader;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CreateCommand extends ContainerAwareCommand
{
    use CommandBehavior;

    public function configure()
    {
        $this
            ->setName('orm:database:create')
            ->setDescription('Create database from various sources')
            ->addOption('source', 's', InputOption::VALUE_OPTIONAL, 'Allowed values: yml, database', 'yml')
            ->setHelp('Call your network administrator');
    }

    public function run(InputInterface $input, OutputInterface $output)
    {
        $output->writeln($this->getMemoryUsage());

        if (!($source = $input->hasOption('source'))) {
            $sources[] = 'yml';
        }
        $output->writeln('<info>>>> ORM</info> Loading sources...');
        $sources = $this->createSourcesFromOptions($input->getOptions());
        $output->writeln('<info>>>> ORM</info> Loading drivers...');
        $drivers = $this->createDriversFromSources($sources);
        /** @var SchemaLoader $schemaLoader */
        $schemaLoader = $this->getContainer()->get('orm.database.schema_loader');
        $schemaLoader->setDrivers($drivers);
        $output->writeln('<info>>>> ORM</info> Loading schema...');
        $schemaLoader->load();

        $output->writeln($this->getMemoryUsage());
    }
} 
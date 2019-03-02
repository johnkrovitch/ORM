<?php

namespace App\Command;

use App\Database\Builder\CommandBuilder;
use App\Manager\DatabaseManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CreateDatabaseCommand extends ContainerAwareCommand
{
    public function configure()
    {
        $this
            ->setName('orm:database:create')
            ->setDescription('Create databases')
            ->setHelp('Call your network administrator')
        ;
    }

    public function run(InputInterface $input, OutputInterface $output)
    {
        $style = new SymfonyStyle($input, $output);
        $container = $this->getContainer();

        $style->title('ORM Synchronize database with schema');

        if (!($source = $input->hasOption('source'))) {
            $sources[] = 'yml';
        }
        $style->text('Loading database');
        $databaseManager = $container->get(DatabaseManager::class);
        $databaseManager->load();

        // TODO find all db
        $database = $databaseManager->get('main');

        $commandBuilder = new CommandBuilder();
        // TODO get db name
        $commandBuilder->createDatabase('orm_test');
        $result = $database->getDriver()->command($commandBuilder->getCommand());

        if (true === $result->getData()) {
            $style->success('The database was successfully created !');
        }

        return true;
    }
}

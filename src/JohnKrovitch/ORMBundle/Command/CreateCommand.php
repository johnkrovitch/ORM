<?php

namespace JohnKrovitch\ORMBundle\Command;

use Doctrine\Bundle\DoctrineBundle\Command\DoctrineCommand;
use JohnKrovitch\ORMBundle\Database\Schema\SchemaLoader;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateCommand extends DoctrineCommand
{
    public function configure()
    {
        $this
            ->setName('database:create')
            ->setDescription('Create database from schema.yml')
            ->setHelp('Call your network administrator');
    }

    public function run(InputInterface $input, OutputInterface $output)
    {
        /** @var SchemaLoader $schemaLoader */
        $schemaLoader = $this->getContainer()->get('orm.database.schema_loader');
        $schemaLoader->load();
    }
} 
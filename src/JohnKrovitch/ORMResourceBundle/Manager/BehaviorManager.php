<?php

namespace JohnKrovitch\ORMResourceBundle\Manager;

use JohnKrovitch\ORMBundle\Behavior\HasContainer;
use JohnKrovitch\ORMBundle\DataSource\Schema\Behavior;
use JohnKrovitch\ORMBundle\DataSource\Schema\Schema;
use JohnKrovitch\ORMBundle\DataSource\Schema\Table;
use JohnKrovitch\ORMResourceBundle\Behavior\HasORMBehaviors;

class BehaviorManager
{
    use HasContainer, HasORMBehaviors;

    /**
     * Load behavior from schema
     *
     * @param Schema $schema
     */
    public function load(Schema $schema)
    {
        //$this->getContainer()->

        //$knownBehaviors =
        $tables = $schema->getTables();

        /** @var Table $table */
        foreach ($tables as $table) {
            $behaviors = $table->getBehaviors();

            /** @var Behavior $behavior */
            foreach ($behaviors as $behavior) {

            }
        }
    }
} 
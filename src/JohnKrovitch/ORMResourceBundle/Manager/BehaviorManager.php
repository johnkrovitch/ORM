<?php

namespace JohnKrovitch\ORMResourceBundle\Manager;

use Exception;
use JohnKrovitch\ORMBundle\Behavior\HasContainer;
use JohnKrovitch\ORMBundle\DataSource\Schema\Column;
use JohnKrovitch\ORMBundle\DataSource\Schema\Schema;
use JohnKrovitch\ORMBundle\DataSource\Schema\Table;
use JohnKrovitch\ORMBundle\Event\SchemaEvent;
use JohnKrovitch\ORMResourceBundle\Behavior\HasORMBehaviors;

class BehaviorManager
{
    use HasContainer, HasORMBehaviors;

    /**
     * Load behavior from schema
     *
     * @param Schema $schema
     * @throws Exception
     */
    public function load(Schema $schema)
    {
        // declared behaviors have been injected into the manager
        $knownBehaviors = $this->getBehaviors();
        $tables = $schema->getTables();

        /** @var Table $table */
        foreach ($tables as $table) {
            // handle tables behaviors
            $behaviorsNames = $table->getBehaviors();
            $tableBehaviors = [];

            foreach ($behaviorsNames as $behaviorName) {
                // behavior are sort by name
                if (!in_array($behaviorName, array_keys($knownBehaviors))) {
                    throw new Exception('Unknown behavior : ' . $behaviorName . ' on table ' . $table->getName());
                }
                $tableBehaviors[] = $knownBehaviors[$behaviorName];
            }
            // transform behavior id into behavior object
            $table->setBehaviors($tableBehaviors);

            // handle columns behaviors
            $columns = $table->getColumns();
            /** @var Column $column */
            foreach ($columns as $column) {
                // handle tables behaviors
                $behaviorsNames = $column->getBehaviors();
                $columnBehaviors = [];

                foreach ($behaviorsNames as $behaviorName) {
                    // behavior are sort by name
                    if (!in_array($behaviorName, array_keys($knownBehaviors))) {
                        throw new Exception('Unknown behavior : ' . $behaviorName . ' on column ' . $column->getName());
                    }
                    $columnBehaviors[] = $knownBehaviors[$behaviorName];
                }
                $column->setBehaviors($columnBehaviors);
            }
        }
    }

    /**
     * Call load method with schema from SchemaEvent
     *
     * @param SchemaEvent $event
     * @throws Exception
     */
    public function dispatchLoad(SchemaEvent $event)
    {
        $this->load($event->getSchema());
    }
} 
<?php

namespace App\Entity\Manager;

use App\Contracts\EntityManagerInterface;
use App\Contracts\MetadataManagerInterface;
use App\Entity\Helper\HashHelper;
use App\Entity\Helper\PrimaryKeyHelper;
use App\Entity\Scheduler\Scheduler;
use App\Exception\Exception;

class EntityManager implements EntityManagerInterface
{
    /**
     * @var MetadataManagerInterface
     */
    private $metadataManager;

    private $entityPool = [];

    private $scheduler;

    public function __construct(MetadataManagerInterface $metadataManager)
    {
        $this->metadataManager = $metadataManager;
        $this->scheduler = new Scheduler();
    }

    public function isManaged($entity): bool
    {
        $metadata = $this->metadataManager->getMetadata(get_class($entity));

        return key_exists(HashHelper::hashEntity($entity, $metadata), $this->entityPool);
    }

    public function persist($entity): void
    {
        if (!is_object($entity)) {
            throw new Exception('Only object can be persisted, given "'.gettype($entity).'"');
        }
        $metadata = $this->metadataManager->getMetadata(get_class($entity));
        $values = PrimaryKeyHelper::getPrimaryKeyValues($entity, $metadata);

        if (0 === count($values)) {
            // No primary keys values has been found, the entity should be created
            $this->scheduler->scheduleForInsertion($entity);

            return;
        }
        $propertyNames = array_keys($metadata->getColumns());

        if ($this->isManaged($entity)) {
            // Entity is managed, it should be updated
        } else {
        }
    }

    public function commit(): void
    {
        // TODO: Implement commit() method.
    }

    public function rollbackTransaction(): void
    {
        // TODO: Implement rollbackTransaction() method.
    }

    public function flush(): void
    {
        // TODO: Implement flush() method.
    }

    public function beginTransaction(): void
    {
        // TODO: Implement beginTransaction() method.
    }
}

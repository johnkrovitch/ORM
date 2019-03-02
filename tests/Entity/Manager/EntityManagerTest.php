<?php

namespace App\Tests\Entity\Manager;

use App\Contracts\MetadataManagerInterface;
use App\Entity\Manager\EntityManager;
use App\Exception\Exception;
use App\Tests\Fixtures\FakeEntity;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class EntityManagerTest extends TestCase
{
    public function testPersist()
    {
        list($entityManager) = $this->createEntityManager();

        $entity = new FakeEntity();

        $entityManager->persist($entity);
    }

    /**
     * @expectedException Exception
     */
    public function testPersistInteger()
    {
        list($entityManager) = $this->createEntityManager();

        $entityManager->persist(666);
    }

    /**
     * @expectedException Exception
     */
    public function testPersistString()
    {
        list($entityManager) = $this->createEntityManager();

        $entityManager->persist('666');
    }

    /**
     * @expectedException Exception
     */
    public function testPersistArray()
    {
        list($entityManager) = $this->createEntityManager();

        $entityManager->persist([
            '666',
        ]);
    }

    /**
     * @return EntityManager[]|MockObject[]
     */
    private function createEntityManager(): array
    {
        $metadataManager = $this->createMock(MetadataManagerInterface::class);

        $entityManager = new EntityManager($metadataManager);

        return [
            $entityManager,
        ];
    }
}

<?php

namespace App\Tests\Entity\Helper;

use App\Database\Schema\Column;
use App\Entity\Helper\HashHelper;
use App\Entity\Metadata\Metadata;
use App\Tests\Fixtures\FakeEntity;
use PHPUnit\Framework\TestCase;

class HashHelperTest extends TestCase
{
    public function testHash()
    {
        $entity = new FakeEntity();
        $entity->id = 666;
        $entity->otherId = 42;

        $id = new Column('id', 'integer', [
            'primary_key' => true,
        ]);
        $otherId = new Column('other_id', 'integer', [
            'primary_key' => true,
        ]);

        $metadata = new Metadata(
            FakeEntity::class,
            'default',
            'default',
            'default',
            'fake_entity',
            [
                'id' => $id,
                'otherId' => $otherId,
            ]
        );

        $hash = HashHelper::hashEntity($entity, $metadata);

        $this->assertEquals(FakeEntity::class.'__666_42', $hash);
    }

    /**
     * @expectedException \App\Exception\PrimaryKeyNotFoundException
     */
    public function testWithoutPrimaryKeys()
    {
        $entity = new FakeEntity();
        $entity->id = 666;
        $entity->otherId = 42;

        $metadata = new Metadata(
            FakeEntity::class,
            'default',
            'default',
            'default',
            'fake_entity',
            [
            ]
        );

        HashHelper::hashEntity($entity, $metadata);
    }

    public function testExtractEntity()
    {
        $data = HashHelper::extractEntity(FakeEntity::class.'__666_42');

        $this->assertCount(2, $data);
        $this->assertArrayHasKey('class', $data);
        $this->assertArrayHasKey('ids', $data);
        $this->assertEquals($data['class'], FakeEntity::class);
        $this->assertEquals($data['ids'], ['666', '42']);
    }

    /**
     * @expectedException \App\Exception\Exception
     */
    public function testExtractEntityWithInvalidHash()
    {
        HashHelper::extractEntity('wrong_hash');
    }

    /**
     * @expectedException \App\Exception\Exception
     */
    public function testExtractEntityWithInvalidHash2()
    {
        HashHelper::extractEntity('wrong__');
    }
}

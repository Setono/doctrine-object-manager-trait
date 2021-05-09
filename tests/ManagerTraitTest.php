<?php

declare(strict_types=1);

namespace Setono\DoctrineObjectManagerTrait\Tests;

use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Setono\DoctrineObjectManagerTrait\ManagerTrait;

final class ManagerTraitTest extends TestCase
{
    use ProphecyTrait;

    /**
     * @test
     */
    public function it_returns_object_manager(): void
    {
        $manager = self::getObjectManager();
        $managerRegistry = $this->prophesize(ManagerRegistry::class);
        $managerRegistry->getManagerForClass(Argument::type('string'))->willReturn($manager);

        $managerTraitAware = new class($managerRegistry->reveal()) {
            use ManagerTrait;

            public function __construct(ManagerRegistry $managerRegistry)
            {
                $this->managerRegistry = $managerRegistry;
            }

            public function getManagerTest(): ObjectManager
            {
                return $this->getManager(new \stdClass());
            }
        };

        self::assertSame($manager, $managerTraitAware->getManagerTest());
    }

    private static function getObjectManager(): ObjectManager
    {
        return new class() implements ObjectManager {
            public function find($className, $id)
            {
                // TODO: Implement find() method.
            }

            public function persist($object)
            {
                // TODO: Implement persist() method.
            }

            public function remove($object)
            {
                // TODO: Implement remove() method.
            }

            public function merge($object)
            {
                // TODO: Implement merge() method.
            }

            public function clear($objectName = null)
            {
                // TODO: Implement clear() method.
            }

            public function detach($object)
            {
                // TODO: Implement detach() method.
            }

            public function refresh($object)
            {
                // TODO: Implement refresh() method.
            }

            public function flush()
            {
                // TODO: Implement flush() method.
            }

            public function getRepository($className)
            {
                // TODO: Implement getRepository() method.
            }

            public function getClassMetadata($className)
            {
                // TODO: Implement getClassMetadata() method.
            }

            public function getMetadataFactory()
            {
                // TODO: Implement getMetadataFactory() method.
            }

            public function initializeObject($obj)
            {
                // TODO: Implement initializeObject() method.
            }

            public function contains($object)
            {
                // TODO: Implement contains() method.
            }
        };
    }
}

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
        $manager = $this->prophesize(ObjectManager::class);
        $managerRegistry = $this->prophesize(ManagerRegistry::class);
        $managerRegistry->getManagerForClass(Argument::type('string'))->willReturn($manager->reveal());

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

        self::assertSame($manager->reveal(), $managerTraitAware->getManagerTest());
    }
}

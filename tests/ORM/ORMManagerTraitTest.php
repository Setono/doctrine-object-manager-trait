<?php

declare(strict_types=1);

namespace Setono\DoctrineObjectManagerTrait\Tests\ORM;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Persistence\ObjectRepository;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Setono\DoctrineObjectManagerTrait\ORM\ORMManagerTrait;

final class ORMManagerTraitTest extends TestCase
{
    use ProphecyTrait;

    /**
     * @test
     */
    public function it_returns_entity_manager(): void
    {
        $manager = $this->prophesize(EntityManagerInterface::class);
        $managerRegistry = $this->prophesize(ManagerRegistry::class);
        $managerRegistry->getManagerForClass(Argument::type('string'))->willReturn($manager->reveal());

        $managerTraitAware = new ConcreteService($managerRegistry->reveal());

        self::assertSame($manager->reveal(), $managerTraitAware->getManagerTest());
    }

    /**
     * @test
     */
    public function it_returns_repository(): void
    {
        $repository = $this->prophesize(ObjectRepository::class);
        $manager = $this->prophesize(EntityManagerInterface::class);
        $manager->getRepository(Argument::type('string'))->willReturn($repository->reveal());
        $managerRegistry = $this->prophesize(ManagerRegistry::class);
        $managerRegistry->getManagerForClass(Argument::type('string'))->willReturn($manager->reveal());

        $managerTraitAware = new ConcreteService($managerRegistry->reveal());

        self::assertSame($repository->reveal(), $managerTraitAware->getRepositoryTest());
    }

    /**
     * @test
     */
    public function it_throws_if_no_manager_exists_for_class(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $managerRegistry = $this->prophesize(ManagerRegistry::class);
        $managerRegistry->getManagerForClass(Argument::type('string'))->willReturn(null);

        $managerTraitAware = new ConcreteService($managerRegistry->reveal());

        $managerTraitAware->getManagerTest();
    }

    /**
     * @test
     */
    public function it_throws_if_manager_is_not_entity_manager(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $manager = $this->prophesize(ObjectManager::class);
        $managerRegistry = $this->prophesize(ManagerRegistry::class);
        $managerRegistry->getManagerForClass(Argument::type('string'))->willReturn($manager->reveal());

        $managerTraitAware = new ConcreteService($managerRegistry->reveal());

        $managerTraitAware->getManagerTest();
    }

    /**
     * @test
     */
    public function it_throws_if_input_is_not_object_nor_string(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $managerRegistry = $this->prophesize(ManagerRegistry::class);

        new class($managerRegistry->reveal()) {
            use ORMManagerTrait;

            public function __construct(ManagerRegistry $managerRegistry)
            {
                $this->managerRegistry = $managerRegistry;

                $this->getManager([]);
            }
        };
    }

    /**
     * @test
     */
    public function it_throws_if_input_is_not_object_nor_string2(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $managerRegistry = $this->prophesize(ManagerRegistry::class);

        new class($managerRegistry->reveal()) {
            use ORMManagerTrait;

            public function __construct(ManagerRegistry $managerRegistry)
            {
                $this->managerRegistry = $managerRegistry;

                $this->getRepository([]);
            }
        };
    }
}

abstract class ManagerTraitAware
{
    use ORMManagerTrait;

    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }
}

final class ConcreteService extends ManagerTraitAware
{
    public function getManagerTest(): EntityManagerInterface
    {
        return $this->getManager(new \stdClass());
    }

    public function getRepositoryTest(): ObjectRepository
    {
        return $this->getRepository(new \stdClass());
    }
}

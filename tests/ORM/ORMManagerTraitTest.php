<?php

declare(strict_types=1);

namespace Setono\DoctrineObjectManagerTrait\Tests\ORM;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
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
    public function it_returns_object_manager(): void
    {
        $manager = $this->prophesize(EntityManagerInterface::class);
        $managerRegistry = $this->prophesize(ManagerRegistry::class);
        $managerRegistry->getManagerForClass(Argument::type('string'))->willReturn($manager->reveal());

        $managerTraitAware = new ConcreteService($managerRegistry->reveal());

        self::assertSame($manager->reveal(), $managerTraitAware->getManagerTest());
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
}

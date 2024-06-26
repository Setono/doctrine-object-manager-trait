<?php

declare(strict_types=1);

namespace Setono\DoctrineObjectManagerTrait\ORM;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectRepository;
use Webmozart\Assert\Assert;

trait ORMManagerTrait
{
    /** @var array<class-string, EntityManagerInterface> */
    private array $managers = [];

    /** @var array<class-string, ObjectRepository> */
    private array $repositories = [];

    private ManagerRegistry $managerRegistry;

    /**
     * @param object|class-string $obj
     */
    protected function getManager(object|string $obj): EntityManagerInterface
    {
        $cls = is_object($obj) ? $obj::class : $obj;

        if (!isset($this->managers[$cls])) {
            $manager = $this->managerRegistry->getManagerForClass($cls);

            Assert::notNull($manager, sprintf('No entity manager exists for class "%s"', $cls));
            Assert::isInstanceOf($manager, EntityManagerInterface::class, sprintf(
                'Expected manager to be of type "%s", but got "%s"',
                EntityManagerInterface::class,
                $manager::class,
            ));

            $this->managers[$cls] = $manager;
        }

        return $this->managers[$cls];
    }

    /**
     * @param object|class-string $obj
     */
    protected function getRepository(object|string $obj): ObjectRepository
    {
        $cls = is_object($obj) ? $obj::class : $obj;

        if (!isset($this->repositories[$cls])) {
            $this->repositories[$cls] = $this->getManager($cls)->getRepository($cls);
        }

        return $this->repositories[$cls];
    }
}

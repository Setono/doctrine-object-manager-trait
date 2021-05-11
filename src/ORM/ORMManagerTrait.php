<?php

declare(strict_types=1);

namespace Setono\DoctrineObjectManagerTrait\ORM;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Webmozart\Assert\Assert;

trait ORMManagerTrait
{
    /** @var array<array-key, EntityManagerInterface> */
    private array $managers = [];

    private ManagerRegistry $managerRegistry;

    /**
     * @param string|object $obj
     */
    protected function getManager($obj): EntityManagerInterface
    {
        $cls = is_object($obj) ? get_class($obj) : $obj;
        Assert::string($cls);

        if (!isset($this->managers[$cls])) {
            $manager = $this->managerRegistry->getManagerForClass($cls);

            Assert::notNull($manager, sprintf('No entity manager exists for class "%s"', $cls));
            Assert::isInstanceOf($manager, EntityManagerInterface::class, sprintf(
                'Expected manager to be of type "%s", but got "%s"',
                EntityManagerInterface::class,
                get_class($manager)
            ));

            $this->managers[$cls] = $manager;
        }

        return $this->managers[$cls];
    }
}

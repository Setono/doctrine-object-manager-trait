<?php

declare(strict_types=1);

namespace Setono\DoctrineObjectManagerTrait;

use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Webmozart\Assert\Assert;

trait ManagerTrait
{
    /** @var array<array-key, ObjectManager> */
    private array $managers = [];

    private ManagerRegistry $managerRegistry;

    /**
     * @param string|object $obj
     */
    protected function getManager($obj): ObjectManager
    {
        $cls = is_object($obj) ? get_class($obj) : $obj;
        Assert::string($cls);

        if (!isset($this->managers[$cls])) {
            $manager = $this->managerRegistry->getManagerForClass($cls);
            Assert::notNull($manager);

            $this->managers[$cls] = $manager;
        }

        return $this->managers[$cls];
    }
}

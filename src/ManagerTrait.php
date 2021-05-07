<?php

declare(strict_types=1);

namespace Setono\DoctrineObjectManagerTrait;

use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Webmozart\Assert\Assert;

trait ManagerTrait
{
    private array $managers = [];

    private ManagerRegistry $managerRegistry;

    /**
     * @param string|object $obj
     */
    protected function getManager($obj): ObjectManager
    {
        $cls = is_object($obj) ? get_class($obj) : $obj;

        if (!isset($this->managers[$cls])) {
            $manager = $this->managerRegistry->getManagerForClass($cls);
            Assert::notNull($manager);

            $this->managers[$cls] = $manager;
        }

        return $this->managers[$cls];
    }
}

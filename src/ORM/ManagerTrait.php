<?php

namespace Setono\DoctrineObjectManagerTrait\ORM;

use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Webmozart\Assert\Assert;

trait ManagerTrait
{
    private array $managers = [];

    private ManagerRegistry $managerRegistry;

    /**
     * @param string|object $obj
     * @return ObjectManager
     */
    private function getManager($obj): ObjectManager
    {
        $cls = is_object($obj) ? get_class($obj) : $obj;

        if(!isset($this->managers[$cls])) {
            $manager = $this->managerRegistry->getManagerForClass($cls);
            Assert::notNull($manager);

            $this->managers[$cls] = $manager;
        }

        return $this->managers[$cls];
    }
}

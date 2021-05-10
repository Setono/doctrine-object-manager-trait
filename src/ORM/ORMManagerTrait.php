<?php

declare(strict_types=1);

namespace Setono\DoctrineObjectManagerTrait\ORM;

use Doctrine\ORM\EntityManagerInterface;
use Setono\DoctrineObjectManagerTrait\ManagerTrait;
use Webmozart\Assert\Assert;

trait ORMManagerTrait
{
    use ManagerTrait {
        getManager as private _getManager;
    }

    protected function getManager($obj): EntityManagerInterface
    {
        $manager = $this->_getManager($obj);
        Assert::isInstanceOf($manager, EntityManagerInterface::class);

        return $manager;
    }
}

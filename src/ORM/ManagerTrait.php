<?php

declare(strict_types=1);

namespace Setono\DoctrineObjectManagerTrait\ORM;

use Doctrine\ORM\EntityManagerInterface;
use Setono\DoctrineObjectManagerTrait\ManagerTrait as BaseManagerTrait;
use Webmozart\Assert\Assert;

trait ManagerTrait
{
    use BaseManagerTrait {
        getManager as getManagerBase;
    }

    protected function getManager($obj): EntityManagerInterface
    {
        $manager = $this->getManagerBase($obj);
        Assert::isInstanceOf($manager, EntityManagerInterface::class);

        return $manager;
    }
}

<?php

declare(strict_types=1);

namespace Setono\DoctrineObjectManagerTrait\ODM\MongoDB;

use Doctrine\ODM\MongoDB\DocumentManager;
use Setono\DoctrineObjectManagerTrait\ManagerTrait;
use Webmozart\Assert\Assert;

trait MongoODMManagerTrait
{
    use ManagerTrait {
        getManager as _getManager;
    }

    protected function getManager($obj): DocumentManager
    {
        $manager = $this->_getManager($obj);
        Assert::isInstanceOf($manager, DocumentManager::class);

        return $manager;
    }
}

# Doctrine Object Manager Trait

[![Latest Version][ico-version]][link-packagist]
[![Latest Unstable Version][ico-unstable-version]][link-packagist]
[![Software License][ico-license]](LICENSE)
[![Build Status][ico-github-actions]][link-github-actions]
[![Code Coverage][ico-code-coverage]][link-code-coverage]
[![Mutation testing][ico-infection]][link-infection]

If you are like and me and usually [don't inject entity managers directly](https://matthiasnoback.nl/2014/05/inject-the-manager-registry-instead-of-the-entity-manager/),
but inject the manager registry instead then this little library will come in handy.

## Installation

```bash
$ composer require setono/doctrine-object-manager-trait
```

## Usage

```php
<?php
use Doctrine\Persistence\ManagerRegistry;
use Setono\DoctrineObjectManagerTrait\ORM\ORMManagerTrait;

final class YourClass
{
    use ORMManagerTrait;
    
    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }
    
    public function someMethod(): void
    {
        /**
         * $entity is an entity managed by Doctrine or a class-string representing an entity managed by Doctrine
         */
        $entity = ;
        
        /**
         * Because we used the ORMManagerTrait above the getManager method will return an EntityManagerInterface
         * 
         * @var \Doctrine\ORM\EntityManagerInterface $manager 
         */
        $manager = $this->getManager($entity);
        
        $manager->persist($entity);
        $manager->flush();
    }
}
```

[ico-version]: https://poser.pugx.org/setono/doctrine-object-manager-trait/v/stable
[ico-unstable-version]: https://poser.pugx.org/setono/doctrine-object-manager-trait/v/unstable
[ico-license]: https://poser.pugx.org/setono/doctrine-object-manager-trait/license
[ico-github-actions]: https://github.com/Setono/doctrine-object-manager-trait/workflows/build/badge.svg
[ico-code-coverage]: https://codecov.io/gh/Setono/doctrine-object-manager-trait/branch/master/graph/badge.svg
[ico-infection]: https://img.shields.io/endpoint?style=flat&url=https%3A%2F%2Fbadge-api.stryker-mutator.io%2Fgithub.com%2FSetono%2Fdoctrine-object-manager-trait%2Fmaster

[link-packagist]: https://packagist.org/packages/setono/doctrine-object-manager-trait
[link-github-actions]: https://github.com/Setono/doctrine-object-manager-trait/actions
[link-code-coverage]: https://codecov.io/gh/Setono/doctrine-object-manager-trait
[link-infection]: https://dashboard.stryker-mutator.io/reports/github.com/Setono/doctrine-object-manager-trait/master

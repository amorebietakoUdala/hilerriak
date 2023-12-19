<?php

namespace App\Factory;

use App\Entity\Cemetery;
use App\Repository\CemeteryRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Cemetery>
 *
 * @method static Cemetery|Proxy createOne(array $attributes = [])
 * @method static Cemetery[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Cemetery[]|Proxy[] createSequence(array|callable $sequence)
 * @method static Cemetery|Proxy find(object|array|mixed $criteria)
 * @method static Cemetery|Proxy findOrCreate(array $attributes)
 * @method static Cemetery|Proxy first(string $sortedField = 'id')
 * @method static Cemetery|Proxy last(string $sortedField = 'id')
 * @method static Cemetery|Proxy random(array $attributes = [])
 * @method static Cemetery|Proxy randomOrCreate(array $attributes = [])
 * @method static Cemetery[]|Proxy[] all()
 * @method static Cemetery[]|Proxy[] findBy(array $attributes)
 * @method static Cemetery[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Cemetery[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static CemeteryRepository|RepositoryProxy repository()
 * @method Cemetery|Proxy create(array|callable $attributes = [])
 */
final class CemeteryFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();

        // TODO inject services if required (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services)
    }

    protected function getDefaults(): array
    {
        return [
            // TODO add your default values here (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories)
            'name' => self::faker()->words(3, true),
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(Cemetery $cemetery): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Cemetery::class;
    }
}

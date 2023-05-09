<?php

namespace App\Factory;

use App\Entity\Grave;
use App\Repository\GraveRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Grave>
 *
 * @method static Grave|Proxy createOne(array $attributes = [])
 * @method static Grave[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Grave[]|Proxy[] createSequence(array|callable $sequence)
 * @method static Grave|Proxy find(object|array|mixed $criteria)
 * @method static Grave|Proxy findOrCreate(array $attributes)
 * @method static Grave|Proxy first(string $sortedField = 'id')
 * @method static Grave|Proxy last(string $sortedField = 'id')
 * @method static Grave|Proxy random(array $attributes = [])
 * @method static Grave|Proxy randomOrCreate(array $attributes = [])
 * @method static Grave[]|Proxy[] all()
 * @method static Grave[]|Proxy[] findBy(array $attributes)
 * @method static Grave[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Grave[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static GraveRepository|RepositoryProxy repository()
 * @method Grave|Proxy create(array|callable $attributes = [])
 */
final class GraveFactory extends ModelFactory
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
            'code' => strtoupper(self::faker()->bothify('?-##-##')),
            // 'description' => self::faker()->words(3,true),
            'years' => self::faker()->numberBetween(10,75),
            // 'expedientCreationYear' => self::faker()->year('+10 years'),
            // 'registrationNumber' => self::faker()->numberBetween(0,9999),
            'free' => self::faker()->boolean(),
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(Grave $grave): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Grave::class;
    }
}

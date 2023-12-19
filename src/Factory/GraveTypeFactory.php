<?php

namespace App\Factory;

use App\Entity\GraveType;
use App\Repository\GraveTypeRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<GraveType>
 *
 * @method static GraveType|Proxy createOne(array $attributes = [])
 * @method static GraveType[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static GraveType[]|Proxy[] createSequence(array|callable $sequence)
 * @method static GraveType|Proxy find(object|array|mixed $criteria)
 * @method static GraveType|Proxy findOrCreate(array $attributes)
 * @method static GraveType|Proxy first(string $sortedField = 'id')
 * @method static GraveType|Proxy last(string $sortedField = 'id')
 * @method static GraveType|Proxy random(array $attributes = [])
 * @method static GraveType|Proxy randomOrCreate(array $attributes = [])
 * @method static GraveType[]|Proxy[] all()
 * @method static GraveType[]|Proxy[] findBy(array $attributes)
 * @method static GraveType[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static GraveType[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static GraveTypeRepository|RepositoryProxy repository()
 * @method GraveType|Proxy create(array|callable $attributes = [])
 */
final class GraveTypeFactory extends ModelFactory
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
            'descriptionEs' => self::faker()->words(3, true).'_es',
            'descriptionEu' => self::faker()->words(3, true).'_eu',
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(GraveType $graveType): void {})
        ;
    }

    protected static function getClass(): string
    {
        return GraveType::class;
    }
}

<?php

namespace App\Factory;

use App\Entity\Owner;
use App\Repository\OwnerRepository;
use DateTime;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Owner>
 *
 * @method static Owner|Proxy createOne(array $attributes = [])
 * @method static Owner[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Owner[]|Proxy[] createSequence(array|callable $sequence)
 * @method static Owner|Proxy find(object|array|mixed $criteria)
 * @method static Owner|Proxy findOrCreate(array $attributes)
 * @method static Owner|Proxy first(string $sortedField = 'id')
 * @method static Owner|Proxy last(string $sortedField = 'id')
 * @method static Owner|Proxy random(array $attributes = [])
 * @method static Owner|Proxy randomOrCreate(array $attributes = [])
 * @method static Owner[]|Proxy[] all()
 * @method static Owner[]|Proxy[] findBy(array $attributes)
 * @method static Owner[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Owner[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static OwnerRepository|RepositoryProxy repository()
 * @method Owner|Proxy create(array|callable $attributes = [])
 */
final class OwnerFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();

        // TODO inject services if required (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services)
    }

    protected function getDefaults(): array
    {
        $name = self::faker()->firstName();
        $surname1 = self::faker()->lastName();
        $surname2 = self::faker()->lastName();
        $fullName = "$name $surname1 $surname2";
        $dni = self::faker()->numberBetween(0,99999999).strtoupper(self::faker()->randomLetter());
        return [
            // TODO add your default values here (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories)
            'dni' => $dni,
            'name' => $name,
            'surname1' => $surname1,
            'surname2' => $surname2,
            'fullname' => $fullName,
            'telephone' => self::faker()->e164PhoneNumber(),
            'createdAt' => new DateTime(),
            'updatedAt' => new DateTime(),
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(Owner $owner): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Owner::class;
    }
}

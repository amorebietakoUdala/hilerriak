<?php

namespace App\DataFixtures;

use App\Entity\GraveType;
use App\Factory\UserFactory;
use App\Factory\CemeteryFactory;
use App\Factory\GraveFactory;
use App\Factory\GraveTypeFactory;
use App\Factory\OwnerFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        UserFactory::createOne([
            'username' => 'ibilbao',
            'email' => 'ibilbao@amorebieta.eus',
            'roles' => ['ROLE_ADMIN']
        ]);  

        UserFactory::createMany(5);

        CemeteryFactory::createOne([
            'name' => 'Leginetxe',
        ]);
        CemeteryFactory::createOne([
            'name' => 'Etxano',
        ]);
        CemeteryFactory::createOne([
            'name' => 'Bernagoitia',
        ]);
        GraveTypeFactory::createOne([
            'id' => GraveType::OCUPATION,
            'descriptionEs' => 'Ocupación_es',
            'descriptionEu' => 'Ocupación_eu',
        ]);
        GraveTypeFactory::createOne([
            'id' => GraveType::REST,
            'descriptionEs' => 'Restos_es',
            'descriptionEu' => 'Restos_eu',
        ]);
        GraveTypeFactory::createOne([
            'id' => GraveType::PANTEON,
            'descriptionEs' => 'Panteon_es',
            'descriptionEu' => 'Panteon_eu',
        ]);
        GraveTypeFactory::createOne([
            'id' => GraveType::ASHES,
            'descriptionEs' => 'Cenizas_es',
            'descriptionEu' => 'Cenizas_eu',
        ]);
        GraveTypeFactory::createOne([
            'id' => GraveType::PIT,
            'descriptionEs' => 'Fosa_es',
            'descriptionEu' => 'Fosa_eu',
        ]);
        OwnerFactory::createMany(10);

        // GraveFactory::createMany(200, function() {
        //     return [
        //         'cemetery' => CemeteryFactory::random(),
        //         'type' => GraveTypeFactory::random(),
        //     ];
        // });
        $manager->flush();
    }
}

<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\House;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private UserPasswordEncoderInterface $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        // Create user ADMIN
        $admin = (new User())
            ->setEmail('gabriel@yopmail.com')
            ->setFirstName($faker->firstNameMale)
            ->setLastName($faker->lastName);
        $admin->setPassword($this->encoder->encodePassword($admin, 'qwerty'));

        $manager->persist($admin);

        // Create some houses
        $heats = [House::HEAT_ELECTRIC, House::HEAT_GAS];
        for ($i = 1; $i <= 10; $i++) {
            $bedrooms = mt_rand(1, 4);
            $surface  = $bedrooms * 25;
            $house    = (new House())
                ->setTitle($faker->words(mt_rand(2, 5), true))
                ->setAddress($faker->address)
                ->setCity($faker->city)
                ->setZipCode($faker->postcode)
                ->setBedrooms($bedrooms)
                ->setDescription($faker->text)
                ->setFloor(mt_rand(1, 4))
                ->setPrice(mt_rand(150000, 540000))
                ->setHeat($heats[mt_rand(0, 1)])
                ->setRooms(++$bedrooms)
                ->setSurface($surface);
            $manager->persist($house);
        }

        $manager->flush();
    }
}

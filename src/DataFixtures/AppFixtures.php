<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\User\User as UserUser;
use Symfony\Component\Console\CommandLoader\FactoryCommandLoader;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $faker = Factory::create('fr_FR');
        $faker->seed(0);

        $user = new User();
        $user
            ->setEmail('user@ex.com')
            ->setPassword($this->encoder->encodePassword($user,'user'))
            ->setFirstname($faker->firstName)
            ->setLastname($faker->lastName)
            ->setPseudo($faker->firstname)
            ;
        
        $manager->persist($user);

        $admin = new User();
        $admin
            ->setEmail('admin@ex.com')
            ->setPassword($this->encoder->encodePassword($admin,'admin'))
            ->setFirstname($faker->firstName)
            ->setLastname($faker->lastName)
            ->setPseudo($faker->firstName)
            ->setRoles(['ROLE_ADMIN'])
            ;
        
        $manager->persist($admin);

        $manager->flush();
    }
}

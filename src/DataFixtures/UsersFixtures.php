<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\User\User as UserUser;
use Symfony\Component\Console\CommandLoader\FactoryCommandLoader;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UsersFixtures extends Fixture
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
            ->setRoles(['ROLE_U'])
            ;
        
        $manager->persist($user);
        $this->addReference('firstUser', $user);


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
        $this->addReference('firstAdmin', $admin);

        //Faker is used here to create a set of users, and some of them 
        //(about one out of ten in this set) will be admins
        for ($i=1; $i < 25; $i++) 
        { 
            $genUser = new User();
            $genUser
                ->setEmail($faker->email)
                ->setRoles(($i%10!=0)?['ROLE_USER']:['ROLE_ADMIN'])
                ->setPassword($this->encoder->encodePassword($genUser,'user'))
                ->setLastName($faker->lastName)
                ->setFirstName($faker->firstName)
                ->setPseudo($faker->userName);
                $manager->persist($genUser);

                $this->addReference('users_user'.$i, $genUser);

        }

        $manager->flush();
    }
}

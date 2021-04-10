<?php

namespace App\DataFixtures;

use App\Entity\Contact;
use Faker\Factory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\User\User as UserUser;
use Symfony\Component\Console\CommandLoader\FactoryCommandLoader;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ContactsFixtures extends Fixture /**implements DependentFixtureInterface */ 
{

    public function load(ObjectManager $manager)
    {

        $faker = Factory::create('fr_FR');
        $faker->seed(0);
        for ($i=0; $i < 5; $i++) { 
            $contact = new Contact();
            $contact
                ->setfirstname($faker->lastName)
                ->setlastname($faker->firstName)
                ->setMailContact($faker->email)
                ->setMessageContact($faker->realText(90))
                ->setTelephone($faker->phoneNumber())
                ;
            $manager->persist($contact);
        }
        
        $manager->flush();
    }
}

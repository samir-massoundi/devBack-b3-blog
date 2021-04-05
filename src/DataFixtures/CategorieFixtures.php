<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use Faker\Factory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CategorieFixtures extends Fixture
{


    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $faker = Factory::create('fr_FR');
        $faker->seed(0);

        $categories = [
            1=> [
                'name' => 'Tips Clip Studio'
            ],
            2=> [
                'name' => 'Tips Photoshop'
            ],
            3=> [
                'name' => 'Tips Procreate'
            ],
            4=> [
                'name' => 'Illustration'
            ],
            5=> [
                'name' => 'Sketch'
            ],
        ];

        foreach ($categories as $key => $value) {
            $categorie = new Categorie();
            $categorie->setname($value['name']);
            $manager->persist($categorie);
        }
        
      
        
        $manager->flush();
    }
}

<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use Faker\Factory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CategoriesFixtures extends Fixture
{


    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $faker = Factory::create('fr_FR');
        $faker->seed(0);

        $category = [
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

        foreach ($category as $key => $value) 
        {
            $category = new Categorie();
            $category->setname($value['name']);
            $manager->persist($category);
            $this->addReference('categories_category'.$key, $category);
        }
        $manager->flush();
    }
}

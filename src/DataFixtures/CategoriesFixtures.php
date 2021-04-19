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
                'name' => 'Focus artiste'
            ],
            2=> [
                'name' => 'Focus album'
            ],
            3=> [
                'name' => 'Actualités'
            ],
            4=> [
                'name' => 'Focus groupe'
            ],
            5=> [
                'name' => 'Brèves'
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

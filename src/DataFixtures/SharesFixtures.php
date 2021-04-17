<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Shares;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class SharesFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $faker = Factory::create();
        $faker->seed(2);

        for ($i = 0; $i < 20; $i++) {
            $user = $this->getReference('users_user' . $faker->numberBetween(1, 24));
            $article = $this->getReference('articles_article' . $faker->numberBetween(0, 19));
            
            $share = new Shares();
            $share
                ->setArticles($article)
                ->setUser($user)
                ->setSharedAt($faker->dateTimeInInterval('-10 months', '+6 months'));
            $manager->persist($share);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            UsersFixtures::class,
            ArticlesFixtures::class
        );
    }
}

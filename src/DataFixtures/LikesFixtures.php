<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Article;
use App\Entity\Likes;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class LikesFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $faker = Factory::create();
        $faker->seed(0);

        for ($i = 0; $i < 300; $i++) {
            $user = $this->getReference('users_user' . $faker->numberBetween(1, 24));
            $article = $this->getReference('articles_article' . $faker->numberBetween(0, 19));

            $like = new Likes();
            $like
                // ->setArticle($article)
                // ->setUser($user)
                ->setLikedAt($faker->dateTimeInInterval('-10 months', '+6 months'));
            $manager->persist($like);
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

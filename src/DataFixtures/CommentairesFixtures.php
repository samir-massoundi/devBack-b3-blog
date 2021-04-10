<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Commentaire;
use Faker\Factory;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\Security\Core\User\User as UserUser;
use Symfony\Component\Console\CommandLoader\FactoryCommandLoader;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CommentairesFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $faker = Factory::create('fr_FR');
        $faker->seed(0);

        for ($i=0; $i < 100 ; $i++) { 
            $user = $this->getReference('users_user'.$faker->numberBetween(1,24));
            $article = $this->getReference('articles_article'.$faker->numberBetween(0,19));
            $commentaire = new Commentaire();
            $commentaire
                ->setUser($user)
                ->setArticle($article)
                ->setDate($faker->dateTimeInInterval('-6 months','+6 months'))
                ->setState(($i%2)?'0':'1')
                ->setContent($faker->realText(500))
                ;
                $manager->persist($commentaire);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            ArticlesFixtures::class,
            UsersFixtures::class
        );
    }
}

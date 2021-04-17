<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Commentaire;
use App\Entity\User;
use App\Repository\ArticleRepository;
use App\Repository\CommentaireRepository;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\Criteria;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;



/**
 * @Route("/dashboard", name="dashboard")
 * @IsGranted("ROLE_USER")
 */
class DashboardController extends AbstractController
{   

    /**
     * @Route("/", name="")
     */
    public function default()
    {
        return $this->redirectToRoute('dashboardhome');
    }
    
    /**
     * @Route("/home", name="home", methods={"GET"})
     */
    public function index(CommentaireRepository $commentaireRepository, UserRepository $userRepository): Response
    {   
        $criteria = Criteria::create()->orderBy(["date"=>Criteria::DESC]);         
        $commented =$this
                    ->getUser()
                    ->getCommentaires()
                    ->matching($criteria)
                    ->slice(0, 5);

        $criteria = Criteria::create()->orderBy(["likedAt"=>Criteria::DESC]); 
        $liked =$this
                    ->getUser()
                    ->getLikes()
                    ->matching($criteria)
                    ->slice(0, 5);

        $criteria = Criteria::create()->orderBy(["sharedAt"=>Criteria::DESC]); 
        $shared    =$this
                    ->getUser()
                    ->getShares()
                    ->matching($criteria)
                    ->slice(0, 5);

        return $this->render('dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
            'commented' => $commented,
            'liked' => $liked,
            'shared'=> $shared

        ]);
    }

    /**
     * @Route("/account-info", name="account-info", methods={"GET","POST"})
     */
    public function infos(): Response
    {
        return $this->render('dashboard/account-info.html.twig');
    }

    /**
     * @Route("/password-edit", name="password-edit", methods={"GET","POST"})
     */
    public function passowrdEdit(): Response
    {
        return $this->render('dashboard/account-info.html.twig');
    }

    /**
     * @Route("/liked-articles", name="liked-articles", methods={"GET"})
     */
    public function likedArticles(): Response
    {
        return $this->render('dashboard/liked-articles.html.twig');
    }

    /**
     * @Route("/shared-articles", name="shared-articles", methods={"GET"})
     */
    public function sharedArticles(): Response
    {
        return $this->render('dashboard/shared-articles.html.twig');
    }

    /**
     * @Route("/shared-articles", name="shared-articles", methods={"GET"})
     */
    public function commentedArticles(): Response
    {
        return $this->render('dashboard/commented-articles.html.twig');
    }
}



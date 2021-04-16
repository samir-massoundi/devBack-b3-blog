<?php

namespace App\Controller;

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
    public function index(): Response
    {
        return $this->render('dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
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
     * @Route("/shared-articles", name="liked-articles", methods={"GET"})
     */
    public function sharedArticles(): Response
    {
        return $this->render('dashboard/liked-articles.html.twig');
    }
}



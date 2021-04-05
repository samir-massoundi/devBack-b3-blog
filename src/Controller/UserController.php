<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/register", name="register")
     */
    public function index(): Response
    {
        $user = new User();
        $form = $this->createForm(RegisterFormType::class,$user);


        return $this->render('user/register.html.twig', [
           'form' => $form->createView(),
        ]);
    }
}

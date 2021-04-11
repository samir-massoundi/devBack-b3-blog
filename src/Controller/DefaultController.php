<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\UserRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(Request $request, ArticleRepository $articleRepository, PaginatorInterface $paginator): Response
    {
        $data = $articleRepository->findBy([], ['createdAt' => 'desc']);
        $articles = $paginator->paginate(
            $data,
            $request->query->getInt('page',1),
            5
        );
        return $this->render('base.html.twig', [
            'articles'=> $articles,
            ]);
    }
}

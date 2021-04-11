<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Repository\CommentaireRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("article")
 */
class ArticleController extends AbstractController
{
    /**
     * @Route("/list", name="article_index",methods={"GET"} )
     */
    public function index(ArticleRepository $articleRepository, UserRepository $userRepository): Response
    {   
        return $this->render('article/index.html.twig', [
            'articles'=>$articleRepository->findAll(),
            'users'=>$userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}", name="article_show", methods={"GET"} )
     */
    public function show(Article $article, CommentaireRepository $commentaireRepository, ArticleRepository $articleRepository) : Response
    {
        $comments = $commentaireRepository->findBy(['article'=> $article, 'state' => '1']);
        $lastArticles = $articleRepository->findBy([], ['createdAt' => 'desc'], 4);
        dump($lastArticles);
        return $this->render('/article/show.html.twig', [
            'article' => $article,
            'comments' =>$comments,
            'lastArticles' => $lastArticles,
        ]);
    }
}

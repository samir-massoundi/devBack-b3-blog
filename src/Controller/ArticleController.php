<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Commentaire;
use App\Form\CommentaireFormType;
use App\Repository\ArticleRepository;
use App\Repository\CommentaireRepository;
use App\Repository\UserRepository;
use DateTime;
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
     * @Route("/{id}", name="article_show", methods={"GET","POST"} )
     */
    public function show(Article $article, 
                        CommentaireRepository $commentaireRepository, 
                        ArticleRepository $articleRepository,
                        Request $request) : Response
    {   
        if($article->getIsVisible() == false)
        {
            echo(false);
            throw $this->createAccessDeniedException('L\'article n\'est pas disponible');

        }
        if(!$article)
        {
            throw $this->createAccessDeniedException('L\'article n\'existe pas');
        }

        $comments = $commentaireRepository->findBy(['article'=> $article, 'state' => '1']);
        $lastArticles = $articleRepository->findBy(['isVisible'=> 1], ['createdAt' => 'desc'], 4);
        $user = $this->getUser();

        //instancie une entité Commentaire
        $newComment = new Commentaire;
        $form = $this->createForm(CommentaireFormType::class, $newComment);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //Formulaire envoyé et données valides
            $newComment->setArticle($article);
            $newComment->setDate(new DateTime());
            $newComment->setState('En cours de validation');
            $newComment->setUser($user);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($newComment);
            $entityManager->flush();
            return $this->redirectToRoute('article_show', ['id' => $article->getId()]);
        }
        
        return $this->render('/article/show.html.twig', [
            'article' => $article,
            'commentForm' =>$form->createView(),
            'comments' =>$comments,
            'lastArticles' => $lastArticles,
        ]);
    }
}

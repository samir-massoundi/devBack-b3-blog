<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\CommentaireRepository;
use Doctrine\Common\Collections\Criteria;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;

/** 
 * @Route("admin/dashboard")
 * @IsGranted("ROLE_ADMIN") 
 * 
*/
class AdminDashboardController extends AbstractController
{
    /**
     * @Route("/", name="admin_dashboard")
     */
    public function index(  ArticleRepository $articleRepository,
                            CommentaireRepository $commentaireRepository): Response
    {
        $lastArticles = $articleRepository->findBy(['isVisible'=> 1], ['createdAt' => 'desc'], 5);

        $nbCommentsToReview = $commentaireRepository->count(['state'=> '0']);

        $user = $this->getUser();

        return $this->render('admin_dashboard/index.html.twig', [
            'lastArticles' => $lastArticles,
            'nbCommentsToReview' => $nbCommentsToReview,
        ]);
    }

    /**
     * @Route("/mes-articles", name="my-articles", methods={"GET"})
     */
    public function myArticles( Request $request,
                                CommentaireRepository $commentaireRepository,
                                ArticleRepository $articleRepository,
                                PaginatorInterface $paginator) : Response
    {   
        $nbCommentsToReview = $commentaireRepository->count(['state'=> '0']);
    
        $data=$articleRepository->findBy(['auteur' => $this->getUser()->getId() ], ['createdAt'=> 'desc']);
        $myArticles = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            5
        );

        return $this->render('admin_dashboard/my-articles.html.twig',
        [
            'myArticles' => $myArticles,
            'nbCommentsToReview' => $nbCommentsToReview,
        ]);
    }

    /**
     * @Route("/gestion-commentaires", name="commentReview", methods={"GET", "POST"})
     */
}

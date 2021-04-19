<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Commentaire;
use App\Form\ArticleFormType;
use App\Form\CommentaireStateFormType;
use App\Repository\ArticleRepository;
use App\Repository\CommentaireRepository;
use App\Repository\ContactRepository;
use DateTime;
use Doctrine\Common\Collections\Criteria;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mime\Message;

/** 
 * @Route("admin/dashboard")
 * @IsGranted("ROLE_ADMIN") 
 */
class AdminDashboardController extends AbstractController
{
    /**
     * @Route("/", name="admin_dashboard")
     */
    public function index(
        ArticleRepository $articleRepository,
        CommentaireRepository $commentaireRepository
    ): Response {
        $lastArticles = $articleRepository->findBy(['isVisible' => 1], ['createdAt' => 'desc'], 5);

        $nbCommentsToReview = $commentaireRepository->count(['state' => '0']);

        $user = $this->getUser();

        return $this->render('admin_dashboard/index.html.twig', [
            'lastArticles' => $lastArticles,
            'nbCommentsToReview' => $nbCommentsToReview,
        ]);
    }

    /**
     * @Route("/mes-articles", name="my-articles", methods={"GET"})
     */
    public function myArticles(
        Request $request,
        CommentaireRepository $commentaireRepository,
        ArticleRepository $articleRepository,
        PaginatorInterface $paginator
    ): Response {
        $nbCommentsToReview = $commentaireRepository->count(['state' => '0']);

        $data = $articleRepository->findBy(['auteur' => $this->getUser()->getId()], ['createdAt' => 'desc']);
        $myArticles = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            5
        );

        return $this->render(
            'admin_dashboard/my-articles.html.twig',
            [
                'myArticles' => $myArticles,
                'nbCommentsToReview' => $nbCommentsToReview,
            ]
        );
    }

    /**
     * @Route("/gestion-commentaire", name="comment-review", methods={"GET", "POST"})
     */
    public function reviewComments(
        Request $request,
        CommentaireRepository $commentaireRepository,
        PaginatorInterface $paginator
    ): Response {
        $data = $commentaireRepository->findBy(['state' => '0']);

        $nbCommentsToReview = $commentaireRepository->count(['state' => '0']);
        $comments = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            10
        );
        return $this->render(
            'admin_dashboard/comment-review.html.twig',
            [
                'comments' => $comments,
                'nbCommentsToReview' => $nbCommentsToReview
            ]
        );
    }

    /**
     * @Route("/rediger-article", name="article-create", methods={"GET", "POST"})
     */
    public function createArticle(
        Request $request, 
        CommentaireRepository $commentaireRepository) : Response
    {
        $nbCommentsToReview = $commentaireRepository->count(['state' => '0']);

        $article = new Article();
        $form = $this->createForm(ArticleFormType::class,$article);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $article->setcreatedAt(new DateTime());
            $article->setAuteur($this->getUser());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();
            return $this->redirectToRoute('my-articles', [
                'message' => 'Votre Article à été ajoutés dans votre liste'
            ]);

        }
        return $this->render('admin_dashboard/article.html.twig',
        [   
            'form' => $form->createView(), 
            'nbCommentsToReview' => $nbCommentsToReview,
            'title' => 'Rédiger un nouvel article'
        ]);
    }

    /**
     * @Route("/article/{id}", name="article_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Article $article): Response
    {
        if ($this->isCsrfTokenValid('delete' . $article->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($article);
            $entityManager->flush();
        }

        return $this->redirectToRoute('my-articles');
    }

    /**
     * @Route("/comment/{id}", name="comment_delete", methods={"DELETE"})
     */
    public function deleteComment(Request $request, Commentaire $commentaire): Response
    {
        if ($this->isCsrfTokenValid('delete' . $commentaire->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($commentaire);
            $entityManager->flush();
        }

        return $this->redirectToRoute('comment-review');
    }

    /**
     * @Route("/contact-inbox", name="contact", methods={"GET"})
     */
    public function contact(
        Request $request,
        ContactRepository $contactRepository,
        CommentaireRepository $commentaireRepository,
        PaginatorInterface $paginator
        ): Response
    {
        $nbCommentsToReview = $commentaireRepository->count(['state' => '0']);

        $data = $contactRepository->findAll();
        $contact = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('admin_dashboard/contact.html.twig',
        [   
            'contact' => $contact,
            'nbCommentsToReview' => $nbCommentsToReview,
            'title' => 'Rédiger un nouvel article'
        ]);
    }

    /**
     * @Route("/{id}/edit", name="comment_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Commentaire $commentaire): Response
    {
        $form = $this->createForm(CommentaireStateFormType::class, $commentaire);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('comment-review');
        }

        return $this->render('admin_dashboard/comment_edit.html.twig', [
            'comment' => $commentaire,
            'form' => $form->createView(),
        ]);
    }
}

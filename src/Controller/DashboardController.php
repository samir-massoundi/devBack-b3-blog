<?php

namespace App\Controller;

use App\Form\PasswordEditFormType;
use App\Form\UserDataFormType;
use App\Repository\CommentaireRepository;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\Criteria;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

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
        $criteria = Criteria::create()->orderBy(["date" => Criteria::DESC]);
        $commented = $this
            ->getUser()
            ->getCommentaires()
            ->matching($criteria)
            ->slice(0, 5);

        $criteria = Criteria::create()->orderBy(["likedAt" => Criteria::DESC]);
        $liked = $this
            ->getUser()
            ->getLikes()
            ->matching($criteria)
            ->slice(0, 5);

        $criteria = Criteria::create()->orderBy(["sharedAt" => Criteria::DESC]);
        $shared    = $this
            ->getUser()
            ->getShares()
            ->matching($criteria)
            ->slice(0, 5);

        return $this->render('dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
            'commented' => $commented,
            'liked' => $liked,
            'shared' => $shared

        ]);
    }

    /**
     * @Route("/account-info", name="account-info", methods={"GET","POST"})
     */
    public function infos(Request $request): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(UserDataFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('dashboardhome');
        }
        return $this->render(
            'dashboard/account-info.html.twig',
            [
                'user' => $user,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/password-edit", name="password-edit", methods={"GET", "POST"})
     */
    public function pwEdit(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(PasswordEditFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($encoder->encodePassword($user, $user->getPassword()));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
        }
        return $this->render(
            'dashboard/password-edit.html.twig',
            [
                'user' => $user,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/liked-articles", name="liked-articles", methods={"GET"})
     */
    public function likedArticles(Request $request, PaginatorInterface $paginator): Response
    {
        $criteria = Criteria::create()->orderBy(["likedAt" => Criteria::DESC]);
        $data = $this
            ->getUser()
            ->getLikes()
            ->matching($criteria);
        $liked = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            10,
        );
        dump($liked);
        return $this->render('dashboard/liked-articles.html.twig',
    [
        'liked' => $liked,
    ]);
    }

    /**
     * @Route("/shared-articles", name="shared-articles", methods={"GET"})
     */
    public function sharedArticles(Request $request, PaginatorInterface $paginator): Response
    {
        $criteria = Criteria::create()->orderBy(["sharedAt" => Criteria::DESC]);
        $data = $this
            ->getUser()
            ->getShares()
            ->matching($criteria);
        $shared = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            10,
        );
        dump($shared);
        return $this->render('dashboard/shared-articles.html.twig',
        [
            'shared'=> $shared
        ]);
    }

    /**
     * @Route("/commented-articles", name="commented-articles", methods={"GET"})
     */
    public function commentedArticles(Request $request, PaginatorInterface $paginator): Response
    {
        $criteria = Criteria::create()->orderBy(["date" => Criteria::DESC]);
        $data = $this
            ->getUser()
            ->getCommentaires()
            ->matching($criteria);
        $commented = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            10,
        );
        dump($commented);

        return $this->render('dashboard/commented-articles.html.twig',  [
            'commented' => $commented
        ]);
    }
}

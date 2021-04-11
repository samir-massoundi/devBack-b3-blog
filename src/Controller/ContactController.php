<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactFormType;
use App\Repository\ContactRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/contact")
 */
class ContactController extends AbstractController
{
    /**
     * @Route("/", name="add_contact_message")
     */
    public function new(Request $request): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactFormType::class,$contact);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($contact);
            $entityManager->flush();
            return $this->redirectToRoute('contact_valid');
        }
        return $this->render('contact/index.html.twig', [
            'controller_name' => 'ContactController',
            'contact' => $contact,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/list", name="contact_index")
     */
    public function index(ContactRepository $contactRepository): Response
    {
        return $this->render('contact/index.html.twig', [
            'controller_name' => 'ContactController',
            'contact' => $contactRepository->findAll(),
        ]);
    }

    /**
     * @Route("/contact_valid", name="contact_valid")
     */
    public function valid()
    {
        return $this->render('contact/valid.html.twig',[]);
    }
}

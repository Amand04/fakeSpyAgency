<?php

namespace App\Controller;

use App\Entity\Contacts;
use App\Form\ContactFormType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactsController extends AbstractController
{
    /**
     * @Route("admin/registerContact", name="app_registerContact")
     */
    public function register(Request $request, EntityManagerInterface $entityManager): Response
    {
        $contact = new Contacts;
        $form = $this->createForm(ContactFormType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $contact = $form->getData();
            $entityManager->persist($contact);
            $entityManager->flush();
            return $this->redirectToRoute("app_admin/contact/index");
        }
        return $this->renderForm('admin/registerContact.html.twig', [
            'form' => $form,
        ]);
    }
    /**
     * @Route("admin/contact/index", name="app_admin/contact/index")
     */
    public function index(ManagerRegistry $doctrine, Request $request, PaginatorInterface $paginator): Response
    {
        $contacts = $doctrine->getRepository(Contacts::class)->findAll();

        $contacts = $paginator->paginate(
            $contacts,
            $request->query->getInt('page', 1),
            6
        );

        return $this->render(
            'admin/contact/index.html.twig',
            ["contacts" => $contacts]
        );
    }

    /**
     * @Route("admin/contact/update/{id}", name="update_contact")
     */
    public function update(Contacts $contact, Request $request, ManagerRegistry $doctrine, PaginatorInterface $paginator): Response
    {


        $form = $this->createForm(ContactFormType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contact = $doctrine->getManager()->flush();

            return $this->redirectToRoute("app_admin/contact/index");
        }

        return $this->renderForm("admin/contact/update.html.twig", [
            "form" => $form,
            "contact" => $contact
        ]);
    }
    /**
     * @Route("admin/contact/delete/{id}", name="delete_contact")
     */
    public function delete(Contacts $contact, Request $request, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $entityManager->remove($contact);
        $entityManager->flush();
        return $this->redirectToRoute("app_admin/contact/index");
    }
}

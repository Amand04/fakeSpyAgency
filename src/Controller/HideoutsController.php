<?php

namespace App\Controller;

use App\Entity\Hideout;
use App\Form\HideoutFormType;
use App\Repository\HideoutsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HideoutsController extends AbstractController
{
    /**
     * @Route("admin/registerHideout", name="app_registerHideout")
     */
    public function register(Request $request, EntityManagerInterface $entityManager): Response
    {
        $hideout = new Hideout();
        $form = $this->createForm(HideoutFormType::class, $hideout);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $hideout = $form->getData();
            $entityManager->persist($hideout);
            $entityManager->flush();
            return $this->redirectToRoute("app_admin/hideout/index");
        }
        return $this->renderForm('admin/registerHideout.html.twig', [
            'form' => $form,
        ]);
    }
    /**
     * @Route("admin/hideout/index", name="app_admin/hideout/index")
     */
    public function index(ManagerRegistry $doctrine, Request $request, PaginatorInterface $paginator): Response
    {
        $hideouts = $doctrine->getRepository(Hideout::class)->findAll();

        $hideouts = $paginator->paginate(
            $hideouts,
            $request->query->getInt('page', 1),
            6
        );
        return $this->render(
            'admin/hideout/index.html.twig',
            ["hideouts" => $hideouts]
        );
    }

    /**
     * @Route("admin/hideout/update/{id}", name="update_hideout")
     */
    public function update(Hideout $hideout, Request $request, ManagerRegistry $doctrine, PaginatorInterface $paginator): Response
    {
        $form = $this->createForm(HideoutFormType::class, $hideout);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hideout = $doctrine->getManager()->flush();

            return $this->redirectToRoute("app_admin/hideout/index");
        }

        return $this->renderForm("admin/hideout/update.html.twig", [
            "form" => $form,
            "hideout" => $hideout
        ]);
    }
    /**
     * @Route("admin/hideout/delete/{id}", name="delete_hideout")
     */
    public function delete(Hideout $hideout, Request $request, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $entityManager->remove($hideout);
        $entityManager->flush();
        return $this->redirectToRoute("app_admin/hideout/index");
    }
}

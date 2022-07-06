<?php

namespace App\Controller;

use App\Entity\Targets;
use App\Form\TargetFormType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TargetsController extends AbstractController
{
    /**
     * @Route("admin/registerTarget", name="app_registerTarget")
     */
    public function register(Request $request, EntityManagerInterface $entityManager): Response
    {
        $target = new Targets();
        $form = $this->createForm(TargetFormType::class, $target);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $target = $form->getData();
            $entityManager->persist($target);
            $entityManager->flush();
            return $this->redirectToRoute("app_admin/target/index");
        }
        return $this->renderForm('admin/registerTarget.html.twig', [
            'form' => $form,
        ]);
    }
    /**
     * @Route("admin/target/index", name="app_admin/target/index")
     */
    public function index(ManagerRegistry $doctrine, Request $request, PaginatorInterface $paginator): Response
    {
        $targets = $doctrine->getRepository(Targets::class)->findAll();

        $targets = $paginator->paginate(
            $targets,
            $request->query->getInt('page', 1),
            6
        );
        return $this->renderForm(
            'admin/target/index.html.twig',
            ["targets" => $targets]
        );
    }

    /**
     * @Route("admin/target/update/{id}", name="update_target")
     */
    public function update(Targets $target, Request $request, ManagerRegistry $doctrine, PaginatorInterface $paginator): Response
    {
        $form = $this->createForm(TargetFormType::class, $target);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $target = $doctrine->getManager()->flush();

            return $this->redirectToRoute("app_admin/target/index");
        }

        return $this->renderForm("admin/target/update.html.twig", [
            "form" => $form,
            "target" => $target
        ]);
    }
    /**
     * @Route("admin/target/delete/{id}", name="delete_target")
     */
    public function delete(Targets $target, Request $request, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $entityManager->remove($target);
        $entityManager->flush();
        return $this->redirectToRoute("app_admin/target/index");
    }
}

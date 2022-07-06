<?php

namespace App\Controller;

use App\Entity\Skills;
use App\Form\SkillFormType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SkillsController extends AbstractController
{
    /**
     * @Route("admin/registerSkill", name="app_registerSkill")
     */
    public function register(Request $request, EntityManagerInterface $entityManager): Response
    {
        $skill = new Skills();
        $form = $this->createForm(SkillFormType::class, $skill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $skill = $form->getData();
            $entityManager->persist($skill);
            $entityManager->flush();

            return $this->redirectToRoute("app_admin/skill/index");
        }
        return $this->renderForm('admin/registerSkill.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * @Route("admin/skill/index", name="app_admin/skill/index")
     */
    public function index(ManagerRegistry $doctrine, Request $request, PaginatorInterface $paginator): Response
    {
        $skills = $doctrine->getRepository(Skills::class)->findAll();

        $skills = $paginator->paginate(
            $skills,
            $request->query->getInt('page', 1),
            6
        );
        return $this->renderForm(
            'admin/skill/index.html.twig',
            ["skills" => $skills]
        );
    }

    /**
     * @Route("admin/skill/update/{id}", name="update_skill")
     */
    public function update(Skills $skills, Request $request, ManagerRegistry $doctrine, PaginatorInterface $paginator): Response
    {
        $form = $this->createForm(SkillFormType::class, $skills);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $skills = $doctrine->getManager()->flush();

            return $this->redirectToRoute("app_admin/skill/index");
        }

        return $this->renderForm("admin/skill/update.html.twig", [
            "form" => $form,
            "skills" => $skills
        ]);
    }

    /**
     * @Route("admin/skill/delete/{id}", name="delete_skill")
     */
    public function delete(Skills $skills, Request $request, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $entityManager->remove($skills);
        $entityManager->flush();
        return $this->redirectToRoute("app_admin/skill/index");
    }
}

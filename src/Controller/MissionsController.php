<?php

namespace App\Controller;

use App\Entity\Missions;
use App\Form\MissionFormType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Routing\Annotation\Route;

class MissionsController extends AbstractController
{

    /**
     * @Route("admin/registerMission", name="app_registerMission")
     */
    public function register(Request $request, EntityManagerInterface $entityManager): Response
    {
        $mission = new Missions();
        $form = $this->createForm(MissionFormType::class, $mission);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if (!$mission->missionValid()) {
                $this->addFlash('Erreur',  'la ou les cibles ne peuvent pas avoir la même nationalité que le ou les agents, les contacts sont obligatoirement de la nationalité du pays de la mission, il faut assigner au moins 1 agent disposant de la spécialité requise!  ');
                return $this->redirectToRoute('app_missionIndex');
            }
            $form->getData();
            $entityManager->persist($mission);
            $entityManager->flush();
            return $this->redirectToRoute("app_missionIndex");
        }
        return $this->render('admin/registerMission.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("mission/index", name="app_missionIndex")
     */
    public function index(Request $request, ManagerRegistry $doctrine, PaginatorInterface $paginator)
    {
        $missions = $doctrine->getRepository(Missions::class)->findAll();

        $missions = $paginator->paginate(
            $missions,
            $request->query->getInt('page', 1),
            6
        );

        return $this->renderForm(
            'mission/index.html.twig',
            [
                "missions" => $missions,
            ]
        );
    }
    /**
     * @Route("admin/mission/update/{id}", name="update_mission")
     */
    public function update(Missions $mission, Request $request, ManagerRegistry $doctrine, PaginatorInterface $paginator): Response
    {
        $form = $this->createForm(MissionFormType::class, $mission);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $missions = $doctrine->getManager()->flush();

            return $this->redirectToRoute("app_missionIndex");
        }

        return $this->renderForm("mission/update.html.twig", [
            "form" => $form,
            "mission" => $mission
        ]);
    }
    /**
     * @Route("admin/mission/delete/{id}", name="delete_mission")
     */
    public function delete(Missions $mission, Request $request, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $entityManager->remove($mission);
        $entityManager->flush();
        return $this->redirectToRoute("app_missionIndex");
    }

    /**
     * @Route("mission/detailMission/{id}", name="app_detailMission")
     */
    public function read(Missions $mission): Response
    {
        return $this->render(
            "mission/detailMission.html.twig",
            [
                "mission" => $mission
            ]
        );
    }
}

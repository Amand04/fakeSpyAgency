<?php

namespace App\Controller;

use App\Entity\Agents;
use App\Entity\Skills;
use App\Form\AgentFormType;
use App\Repository\AgentsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AgentsController extends AbstractController
{
    /**
     * @Route("admin/registerAgent", name="app_registerAgent")
     */
    public function register(Request $request, EntityManagerInterface $entityManager): Response
    {
        $agent = new Agents();
        $form = $this->createForm(AgentFormType::class, $agent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $agent = $form->getData();
            $entityManager->persist($agent);
            $entityManager->flush();
            return $this->redirectToRoute("app_admin/agent/index");
        }
        return $this->renderForm('admin/registerAgent.html.twig', [
            'form' => $form,
            'agent' => $agent,
        ]);
    }
    /**
     * @Route("admin/agent/index", name="app_admin/agent/index")
     */
    public function index(Request $request, ManagerRegistry $doctrine, PaginatorInterface $paginator): Response
    {
        $agents = $doctrine->getRepository(Agents::class)->findAll();
        $skill = $doctrine->getRepository(Skills::class)->findAll();

        $agents = $paginator->paginate(
            $agents,
            $request->query->getInt('page', 1),
            6
        );

        return $this->render(
            'admin/agent/index.html.twig',
            [
                "agents" => $agents,
                "skill" => $skill,
            ]
        );
    }

    /**
     * @Route("admin/agent/update/{id}", name="update_agent")
     */
    public function update(Agents $agent, Request $request, ManagerRegistry $doctrine): Response
    {
        $form = $this->createForm(AgentFormType::class, $agent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $agent = $doctrine->getManager()->flush();

            return $this->redirectToRoute("app_admin/agent/index");
        }

        return $this->renderForm("admin/agent/update.html.twig", [
            "form" => $form,
            "agent" => $agent
        ]);
    }
    /**
     * @Route("admin/agent/delete/{id}", name="delete_agent")
     */
    public function delete(Agents $agent, Request $request, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $entityManager->remove($agent);
        $entityManager->flush();
        return $this->redirectToRoute("app_admin/agent/index");
    }
}

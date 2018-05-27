<?php

namespace App\Controller\Crud;

use App\Entity\Projects;
use App\Form\ProjectsType;
use App\Repository\ProjectsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/projects")
 */
class ProjectsCrudController extends Controller
{
    /**
     * @Route("/", name="projects_index", methods="GET")
     */
    public function index(ProjectsRepository $projectsRepository): Response
    {
        return $this->render('Admin/projects/index.html.twig', ['projects' => $projectsRepository->findAll()]);
    }

    /**
     * @Route("/new", name="projects_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $project = new Projects();
        $form = $this->createForm(ProjectsType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($project);
            $em->flush();

            return $this->redirectToRoute('projects_index');
        }

        return $this->render('Admin/projects/new.html.twig', [
            'project' => $project,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="projects_show", methods="GET")
     */
    public function show(Projects $project): Response
    {
        return $this->render('Admin/projects/show.html.twig', ['project' => $project]);
    }

    /**
     * @Route("/{id}/edit", name="projects_edit", methods="GET|POST")
     */
    public function edit(Request $request, Projects $project): Response
    {
        $form = $this->createForm(ProjectsType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('projects_edit', ['id' => $project->getId()]);
        }

        return $this->render('Admin/projects/edit.html.twig', [
            'project' => $project,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="projects_delete", methods="DELETE")
     */
    public function delete(Request $request, Projects $project): Response
    {
        if ($this->isCsrfTokenValid('delete'.$project->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($project);
            $em->flush();
        }

        return $this->redirectToRoute('projects_index');
    }
}

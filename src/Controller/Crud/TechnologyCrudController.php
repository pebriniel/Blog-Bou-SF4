<?php

namespace App\Controller\Crud;

use App\Entity\Technology;
use App\Form\TechnologyType;
use App\Repository\TechnologyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/technology")
 */
class TechnologyCrudController extends Controller
{
    /**
     * @Route("/", name="technology_index", methods="GET")
     */
    public function index(TechnologyRepository $technologyRepository): Response
    {
        return $this->render('Admin/technology/index.html.twig', ['technologies' => $technologyRepository->findAll()]);
    }

    /**
     * @Route("/new", name="technology_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $technology = new Technology();
        $form = $this->createForm(TechnologyType::class, $technology);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($technology);
            $em->flush();

            return $this->redirectToRoute('technology_index');
        }

        return $this->render('Admin/technology/new.html.twig', [
            'technology' => $technology,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="technology_show", methods="GET")
     */
    public function show(Technology $technology): Response
    {
        return $this->render('Admin/technology/show.html.twig', ['technology' => $technology]);
    }

    /**
     * @Route("/{id}/edit", name="technology_edit", methods="GET|POST")
     */
    public function edit(Request $request, Technology $technology): Response
    {
        $form = $this->createForm(TechnologyType::class, $technology);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('technology_edit', ['id' => $technology->getId()]);
        }

        return $this->render('Admin/technology/edit.html.twig', [
            'technology' => $technology,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="technology_delete", methods="DELETE")
     */
    public function delete(Request $request, Technology $technology): Response
    {
        if ($this->isCsrfTokenValid('delete'.$technology->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($technology);
            $em->flush();
        }

        return $this->redirectToRoute('technology_index');
    }
}

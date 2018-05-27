<?php

namespace App\Controller\Crud;

use App\Entity\Workplace;
use App\Form\WorkplaceType;
use App\Repository\WorkplaceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/workplace")
 */
class WorkplaceCrudController extends Controller
{
    /**
     * @Route("/", name="workplace_index", methods="GET")
     */
    public function index(WorkplaceRepository $workplaceRepository): Response
    {
        return $this->render('Admin/workplace/index.html.twig', ['workplaces' => $workplaceRepository->findAll()]);
    }

    /**
     * @Route("/new", name="workplace_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $workplace = new Workplace();
        $form = $this->createForm(WorkplaceType::class, $workplace);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($workplace);
            $em->flush();

            return $this->redirectToRoute('workplace_index');
        }

        return $this->render('Admin/workplace/new.html.twig', [
            'workplace' => $workplace,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="workplace_show", methods="GET")
     */
    public function show(Workplace $workplace): Response
    {
        return $this->render('Admin/workplace/show.html.twig', ['workplace' => $workplace]);
    }

    /**
     * @Route("/{id}/edit", name="workplace_edit", methods="GET|POST")
     */
    public function edit(Request $request, Workplace $workplace): Response
    {
        $form = $this->createForm(WorkplaceType::class, $workplace);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('workplace_edit', ['id' => $workplace->getId()]);
        }

        return $this->render('Admin/workplace/edit.html.twig', [
            'workplace' => $workplace,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="workplace_delete", methods="DELETE")
     */
    public function delete(Request $request, Workplace $workplace): Response
    {
        if ($this->isCsrfTokenValid('delete'.$workplace->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($workplace);
            $em->flush();
        }

        return $this->redirectToRoute('workplace_index');
    }
}

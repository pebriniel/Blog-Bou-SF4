<?php

namespace App\Controller\Crud;

use App\Entity\Address;
use App\Form\AddressType;
use App\Repository\AddressRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/address")
 */
class AddressCrudController extends Controller
{
    /**
     * @Route("/", name="address_index", methods="GET")
     */
    public function index(AddressRepository $addressRepository): Response
    {
        return $this->render('Admin/address/index.html.twig', ['addresses' => $addressRepository->findAll()]);
    }

    /**
     * @Route("/new", name="address_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $address = new Address();
        $form = $this->createForm(AddressType::class, $address);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($address);
            $em->flush();

            return $this->redirectToRoute('address_index');
        }

        return $this->render('Admin/address/new.html.twig', [
            'address' => $address,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="address_show", methods="GET")
     */
    public function show(Address $address): Response
    {
        return $this->render('Admin/address/show.html.twig', ['address' => $address]);
    }

    /**
     * @Route("/{id}/edit", name="address_edit", methods="GET|POST")
     */
    public function edit(Request $request, Address $address): Response
    {
        $form = $this->createForm(AddressType::class, $address);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('address_edit', ['id' => $address->getId()]);
        }

        return $this->render('Admin/address/edit.html.twig', [
            'address' => $address,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="address_delete", methods="DELETE")
     */
    public function delete(Request $request, Address $address): Response
    {
        if ($this->isCsrfTokenValid('delete'.$address->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($address);
            $em->flush();
        }

        return $this->redirectToRoute('address_index');
    }
}

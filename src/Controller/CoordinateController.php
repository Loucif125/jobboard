<?php

namespace App\Controller;

use App\Entity\Coordinate;
use App\Form\CoordinateType;
use App\Repository\CoordinateRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/coordinate")
 */
class CoordinateController extends AbstractController
{
    /**
     * @Route("/", name="coordinate_index", methods={"GET"})
     */
    public function index(CoordinateRepository $coordinateRepository): Response
    {
        return $this->render('coordinate/index.html.twig', [
            'coordinates' => $coordinateRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="coordinate_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $coordinate = new Coordinate();
        $form = $this->createForm(CoordinateType::class, $coordinate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($coordinate);
            $entityManager->flush();

            return $this->redirectToRoute('coordinate_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('coordinate/new.html.twig', [
            'coordinate' => $coordinate,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="coordinate_show", methods={"GET"})
     */
    public function show(Coordinate $coordinate): Response
    {
        return $this->render('coordinate/show.html.twig', [
            'coordinate' => $coordinate,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="coordinate_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Coordinate $coordinate): Response
    {
        $form = $this->createForm(CoordinateType::class, $coordinate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('coordinate_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('coordinate/edit.html.twig', [
            'coordinate' => $coordinate,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="coordinate_delete", methods={"POST"})
     */
    public function delete(Request $request, Coordinate $coordinate): Response
    {
        if ($this->isCsrfTokenValid('delete'.$coordinate->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($coordinate);
            $entityManager->flush();
        }

        return $this->redirectToRoute('coordinate_index', [], Response::HTTP_SEE_OTHER);
    }
}

<?php

namespace App\Controller;

use App\Entity\Alerte;
use App\Form\AlerteType;
use App\Repository\AlerteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/my/idBien/alerte")
 */
class AlerteController extends AbstractController
{
    /**
     * @Route("/", name="alerte_index", methods={"GET"})
     */
    public function index(AlerteRepository $alerteRepository): Response
    {
        return $this->render('alerte/index.html.twig', [
            'alertes' => $alerteRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="alerte_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $alerte = new Alerte();
        $form = $this->createForm(AlerteType::class, $alerte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($alerte);
            $entityManager->flush();

            return $this->redirectToRoute('alerte_index');
        }

        return $this->render('alerte/new.html.twig', [
            'alerte' => $alerte,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="alerte_show", methods={"GET"})
     */
    public function show(Alerte $alerte): Response
    {
        return $this->render('alerte/show.html.twig', [
            'alerte' => $alerte,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="alerte_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Alerte $alerte): Response
    {
        $form = $this->createForm(AlerteType::class, $alerte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('alerte_index');
        }

        return $this->render('alerte/edit.html.twig', [
            'alerte' => $alerte,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="alerte_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Alerte $alerte): Response
    {
        if ($this->isCsrfTokenValid('delete'.$alerte->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($alerte);
            $entityManager->flush();
        }

        return $this->redirectToRoute('alerte_index');
    }
}

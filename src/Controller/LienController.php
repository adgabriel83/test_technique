<?php

namespace App\Controller;

use App\Entity\Lien;
use App\Form\LienType;
use App\Repository\LienRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/lien')]
class LienController extends AbstractController
{
    #[Route('/', name: 'app_lien_index', methods: ['GET'])]
    public function index(LienRepository $lienRepository): Response
    {
        return $this->render('lien/index.html.twig', [
            'liens' => $lienRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_lien_new', methods: ['GET', 'POST'])]
    public function new(Request $request, LienRepository $lienRepository): Response
    {
        $lien = new Lien();
        $form = $this->createForm(LienType::class, $lien);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $lienRepository->add($lien, true);

            return $this->redirectToRoute('app_lien_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('lien/new.html.twig', [
            'lien' => $lien,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_lien_show', methods: ['GET'])]
    public function show(Lien $lien): Response
    {
        return $this->render('lien/show.html.twig', [
            'lien' => $lien,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_lien_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Lien $lien, LienRepository $lienRepository): Response
    {
        $form = $this->createForm(LienType::class, $lien);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $lienRepository->add($lien, true);

            return $this->redirectToRoute('app_lien_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('lien/edit.html.twig', [
            'lien' => $lien,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_lien_delete', methods: ['POST'])]
    public function delete(Request $request, Lien $lien, LienRepository $lienRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$lien->getId(), $request->request->get('_token'))) {
            $lienRepository->remove($lien, true);
        }

        return $this->redirectToRoute('app_lien_index', [], Response::HTTP_SEE_OTHER);
    }
}

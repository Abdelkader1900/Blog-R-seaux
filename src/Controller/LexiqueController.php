<?php

namespace App\Controller;

use App\Entity\Lexique;
use App\Form\LexiqueType;
use App\Repository\LexiqueRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/lexique')]
final class LexiqueController extends AbstractController
{
    #[Route(name: 'app_lexique_index', methods: ['GET'])]
    public function index(LexiqueRepository $lexiqueRepository): Response
    {
        return $this->render('lexique/index.html.twig', [
            'lexiques' => $lexiqueRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_lexique_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $lexique = new Lexique();
        $form = $this->createForm(LexiqueType::class, $lexique);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($lexique);
            $entityManager->flush();

            return $this->redirectToRoute('app_lexique_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('lexique/new.html.twig', [
            'lexique' => $lexique,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_lexique_show', methods: ['GET'])]
    public function show(Lexique $lexique): Response
    {
        return $this->render('lexique/show.html.twig', [
            'lexique' => $lexique,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_lexique_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Lexique $lexique, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LexiqueType::class, $lexique);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_lexique_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('lexique/edit.html.twig', [
            'lexique' => $lexique,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_lexique_delete', methods: ['POST'])]
    public function delete(Request $request, Lexique $lexique, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$lexique->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($lexique);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_lexique_index', [], Response::HTTP_SEE_OTHER);
    }
}

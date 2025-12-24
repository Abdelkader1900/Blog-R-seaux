<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\LexiqueRepository;

final class PublicController extends AbstractController
{
    #[Route('/', name: 'app_public')]
    public function index(): Response
    {
        return $this->render('public/index.html.twig', [
            'controller_name' => 'PublicController',
        ]);
    }

    #[Route('/definition', name: 'app_definition')]
    public function definition(LexiqueRepository $lexiqueRepository): Response
    {
        $definitions = $lexiqueRepository->findAll();
        return $this->render('public/lexique.html.twig', ['definitions' => $definitions,]);
    }
}

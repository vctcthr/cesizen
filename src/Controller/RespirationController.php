<?php

namespace App\Controller;

use App\Repository\BreathingExerciseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;


class RespirationController extends AbstractController
{
    #[Route('/respiration', name: 'respiration')]
#[IsGranted('ROLE_USER')]
public function index(BreathingExerciseRepository $repo): Response
{
    return $this->render('respiration/index.html.twig', [
        'exercises' => $repo->findAll()
    ]);
}
}
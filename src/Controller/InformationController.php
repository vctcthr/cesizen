<?php

namespace App\Controller;

use App\Repository\InformationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class InformationController extends AbstractController
{
    #[Route('/info', name: 'info')]
    public function index(InformationRepository $repo): Response
    {
        $infos = $repo->findBy(['isActive' => true]);

        return $this->render('information/index.html.twig', [
            'infos' => $infos
        ]);
    }
}
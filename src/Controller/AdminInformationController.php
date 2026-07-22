<?php

namespace App\Controller;

use App\Entity\Information;
use App\Form\InformationType;
use App\Repository\InformationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use DateTimeImmutable;

#[Route('/admin/informations')]
#[IsGranted('ROLE_ADMIN')]
final class AdminInformationController extends AbstractController
{
    #[Route('/', name: 'admin_informations', methods: ['GET'])]
    public function index(InformationRepository $informationRepository): Response
    {
        return $this->render('admin/information/index.html.twig', [
            'infos' => $informationRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'admin_information_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $information = new Information();
        $form = $this->createForm(InformationType::class, $information);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $information->setCreatedAt(new DateTimeImmutable());
            $information->setUser($this->getUser());
        
            $entityManager->persist($information);
            $entityManager->flush();
        
            return $this->redirectToRoute('admin_informations');
        }

        return $this->render('admin/information/new.html.twig', [
            'information' => $information,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_information_show', methods: ['GET'])]
    public function show(Information $information): Response
    {
        return $this->render('admin/information/show.html.twig', [
            'information' => $information,
        ]);
    }

    #[Route('/{id}/edit', name: 'admin_information_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Information $information, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(InformationType::class, $information);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_informations');
        }

        return $this->render('admin/information/edit.html.twig', [
            'information' => $information,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_information_delete', methods: ['POST'])]
    public function delete(Request $request, Information $information, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$information->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($information);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_informations');
    }
}
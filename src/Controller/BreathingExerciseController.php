<?php

namespace App\Controller;

use App\Entity\BreathingExercise;
use App\Form\BreathingExerciseType;
use App\Repository\BreathingExerciseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/exercises')]
#[IsGranted('ROLE_ADMIN')]
final class BreathingExerciseController extends AbstractController
{
    #[Route('/', name: 'admin_exercise_index', methods: ['GET'])]
    public function index(BreathingExerciseRepository $repo): Response
    {
        return $this->render('admin/breathing_exercise/index.html.twig', [
            'breathing_exercises' => $repo->findAll(),
        ]);
    }

    #[Route('/new', name: 'admin_exercise_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $exercise = new BreathingExercise();
        $form = $this->createForm(BreathingExerciseType::class, $exercise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($exercise);
            $entityManager->flush();

            return $this->redirectToRoute('admin_exercise_index');
        }

        return $this->render('admin/breathing_exercise/new.html.twig', [
            'breathing_exercise' => $exercise,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_exercise_show', methods: ['GET'])]
    public function show(BreathingExercise $exercise): Response
    {
        return $this->render('admin/breathing_exercise/show.html.twig', [
            'breathing_exercise' => $exercise,
        ]);
    }

    #[Route('/{id}/edit', name: 'admin_exercise_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, BreathingExercise $exercise, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BreathingExerciseType::class, $exercise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_exercise_index');
        }

        return $this->render('admin/breathing_exercise/edit.html.twig', [
            'breathing_exercise' => $exercise,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_exercise_delete', methods: ['POST'])]
    public function delete(Request $request, BreathingExercise $exercise, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$exercise->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($exercise);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_exercise_index');
    }
}
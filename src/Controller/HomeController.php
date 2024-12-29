<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ProjectRepository;
use App\Repository\UserRepository;
use App\Enum\TaskStatusEnum;
use App\Repository\TaskRepository;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return $this->render('index.html.twig');
    }

    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    #[Route('/project/{id}', name: 'project')]
    public function project(int $id, ProjectRepository $projectRepository, UserRepository $userRepository): Response
    {
        $project = $projectRepository->find($id);

        if (!$project) {
            return $this->redirectToRoute('home');
        }

        $taskStatuses = TaskStatusEnum::cases();
        $projectMembers = $project->getMembers();

        return $this->render('project.html.twig', [
            'project' => $project,
            'taskStatuses' => $taskStatuses,
            'projectMembers' => $projectMembers,
        ]);
    }

    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    #[Route('/task/{id}', name: 'task')]
    public function task(int $id, TaskRepository $taskRepository): Response
    {
        $task = $taskRepository->find($id);

        if (!$task) {
            return $this->redirectToRoute('home');
        }

        return $this->render('task.html.twig', [
            'task' => $task,
        ]);
    }
}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use App\Repository\ProjectRepository;
use App\Enum\TaskStatusEnum;
use App\Repository\UserRepository;
use App\Entity\User;

class ProjectController extends AbstractController
{
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    #[Route('/project/{id}', name: 'project')]
    public function index(int $id, ProjectRepository $projectRepository, UserRepository $userRepository): Response
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
}

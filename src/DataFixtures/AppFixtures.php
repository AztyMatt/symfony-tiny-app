<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use Faker\Factory;
use App\Entity\Team;
use App\Entity\Project;
use App\Entity\Task;
use App\Enum\ProjectStatusEnum;
use App\Enum\TaskStatusEnum;
use App\Enum\TaskPriorityEnum;
use App\Entity\ProjectUser;
use App\Enum\ProjectUserRoleEnum;
use App\Entity\Comment;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        function getRandomDate(): \DateTime {
            $start = strtotime('2023-01-01');
            $end = strtotime('2025-12-31');
            $timestamp = mt_rand($start, $end);
            return (new \DateTime())->setTimestamp($timestamp);
        }

        $users = [
            ['username' => 'Alice', 'email' => 'alice@example.com'],
            ['username' => 'Bob', 'email' => 'bob@example.com'],
            ['username' => 'Charlie', 'email' => 'charlie@example.com'],
            ['username' => 'Dave', 'email' => 'dave@example.com'],
            ['username' => 'Eve', 'email' => 'eve@example.com'],
            ['username' => 'Frank', 'email' => 'frank@example.com'],
            ['username' => 'Grace', 'email' => 'grace@example.com'],
            ['username' => 'Heidi', 'email' => 'heidi@example.com'],
            ['username' => 'Ivan', 'email' => 'ivan@example.com'],
            ['username' => 'Judy', 'email' => 'judy@example.com'],
        ];

        $teams = [
            ['name' => 'Akufen'],
            ['name' => 'Octave - CDS'],
            ['name' => 'Agence 404']
        ];

        $projects = [
            [
                'name' => 'API Development',
                'description' => 'Developing a new REST API to support the mobile and web applications. This includes designing the API endpoints, implementing authentication and authorization, and ensuring scalability and performance.',
                'startDate' => '2023-01-09',
                'endDate' => '2024-06-18',
                'status' => ProjectStatusEnum::COMPLETED
            ],
            [
                'name' => 'Frontend Revamp',
                'description' => 'Revamping the frontend with React to improve user experience and performance. This involves redesigning the UI, implementing new features, and optimizing the codebase for better maintainability.',
                'startDate' => '2023-02-07',
                'endDate' => '2023-07-20',
                'status' => ProjectStatusEnum::COMPLETED
            ],
            [
                'name' => 'Database Optimization',
                'description' => null,
                'startDate' => '2023-03-18',
                'endDate' => '2025-08-03',
                'status' => ProjectStatusEnum::IN_PROGRESS
            ],
            [
                'name' => 'Microservices Migration',
                'description' => 'Migrating the monolithic application to a microservices architecture. This involves breaking down the application into smaller, independent services, setting up communication between services, and ensuring data consistency.',
                'startDate' => '2023-04-05',
                'endDate' => '2025-09-12',
                'status' => ProjectStatusEnum::IN_PROGRESS
            ],
            [
                'name' => 'Mobile App Development',
                'description' => 'Developing a new mobile app for iOS and Android platforms. This includes designing the app interface, implementing core features, and integrating with the backend services.',
                'startDate' => '2023-05-10',
                'endDate' => '2024-10-01',
                'status' => ProjectStatusEnum::IN_PROGRESS
            ],
            [
                'name' => 'Cloud Infrastructure Setup',
                'description' => 'Setting up cloud infrastructure to support the application. This involves configuring cloud services, setting up CI/CD pipelines, and ensuring high availability and scalability.',
                'startDate' => '2023-06-11',
                'endDate' => '2024-11-29',
                'status' => ProjectStatusEnum::IN_PROGRESS
            ],
            [
                'name' => 'Security Enhancements',
                'description' => 'Implementing security enhancements to protect the application from vulnerabilities. This includes conducting security audits, implementing encryption, and setting up monitoring and alerting systems.',
                'startDate' => '2024-07-21',
                'endDate' => '2024-12-09',
                'status' => ProjectStatusEnum::PLANNED
            ],
            [
                'name' => 'DevOps Automation',
                'description' => null,
                'startDate' => '2024-08-17',
                'endDate' => '2026-01-28',
                'status' => ProjectStatusEnum::PLANNED
            ],
            [
                'name' => 'Performance Tuning',
                'description' => 'Tuning application performance to handle increased load and improve response times. This includes profiling the application, optimizing code, and scaling infrastructure as needed.',
                'startDate' => '2019-09-16',
                'endDate' => '2022-02-23',
                'status' => ProjectStatusEnum::ARCHIVED
            ],
            [
                'name' => 'Legacy System Integration',
                'description' => 'Integrating with legacy systems to ensure seamless data flow and interoperability. This involves setting up data synchronization, implementing APIs, and ensuring data consistency across systems.',
                'startDate' => '2022-10-01',
                'endDate' => '2024-03-17',
                'status' => ProjectStatusEnum::ARCHIVED
            ],
        ];

        $tasks = [
            [
                'name' => 'Implement Authentication',
                'description' => 'Develop and integrate authentication mechanisms for the application. This includes setting up user registration, login, password recovery, and session management.',
                'dueDate' => '2023-12-11'
            ],
            [
                'name' => 'Design Database Schema',
                'description' => null,
                'dueDate' => '2023-11-15'
            ],
            [
                'name' => 'Develop API Endpoints',
                'description' => 'Implement RESTful API endpoints to support frontend and mobile applications. This includes creating controllers, services, and ensuring proper request validation and error handling.',
                'dueDate' => '2023-12-22'
            ],
            [
                'name' => 'Setup CI/CD Pipeline',
                'description' => null,
                'dueDate' => '2023-04-05'
            ],
            [
                'name' => 'Optimize Performance',
                'description' => 'Analyze and optimize application performance to handle increased load. This includes profiling the application, optimizing code, and scaling infrastructure as needed.',
                'dueDate' => '2024-01-10'
            ],
            [
                'name' => 'Implement User Roles',
                'description' => 'Define and implement user roles and permissions within the application.',
                'dueDate' => '2023-08-16'
            ],
            [
                'name' => 'Create Unit Tests',
                'description' => 'Write unit tests for the application to ensure code quality and reliability. This involves setting up a testing framework and writing tests for critical components.',
                'dueDate' => '2023-12-25'
            ],
            [
                'name' => 'Setup Logging',
                'description' => 'Implement logging mechanisms to track application events and errors.',
                'dueDate' => '2024-11-05'
            ],
            [
                'name' => 'Integrate Third-Party Services',
                'description' => 'Integrate third-party services such as payment gateways, email providers, and analytics tools. This involves setting up API connections and ensuring secure data exchange.',
                'dueDate' => '2024-05-21'
            ],
            [
                'name' => 'Conduct Code Review',
                'description' => 'Perform code reviews to ensure code quality and adherence to best practices.',
                'dueDate' => '2024-06-30'
            ],
        ];

        $comments = [
            'Great job !',
            'This needs more attention.',
            'Please review the code changes.',
            'The project is progressing well !',
            'We need to discuss the requirements.',
            'The deadline is approaching.',
            'Let’s schedule a meeting.',
            'The task is almost complete.',
            'We need to fix the bugs.',
            'The project is on track.'
        ];

        // Users
        $userEntities = [];
        foreach ($users as $userData) {
            $user = new User();
            $user->setUsername($userData['username']);
            $user->setEmail($userData['email']);
            $user->setPlainPassword('password');
            $user->setProfilePicture('https://avatar.iran.liara.run/public/'.rand(1, 100));

            $manager->persist($user);
            $userEntities[] = $user;
        }

        // Teams
        $teamEntities = [];
        foreach ($teams as $teamData) {
            $team = new Team();
            $team->setName($teamData['name']);
            
            $manager->persist($team);
            $teamEntities[] = $team;
        }

        // Assign teams to users
        foreach ($userEntities as $user) {
            $assignedTeams = (array)array_rand($teamEntities, rand(1, 3));
            foreach ($assignedTeams as $teamIndex) {
                $teamEntities[$teamIndex]->addMember($user);
                $manager->persist($teamEntities[$teamIndex]);
            }
        }

        // Create an admin user
        $adminUser = new User();
        $adminUser->setUsername('Admin');
        $adminUser->setEmail('admin@next-task.com');
        $adminUser->setRoles(['ROLE_ADMIN']);
        $adminUser->setPlainPassword('n3xtT@sk');
        $adminUser->setProfilePicture('https://avatar.iran.liara.run/public/'.rand(1, 100));
        $manager->persist($adminUser);

        // Projects
        $roles = ProjectUserRoleEnum::cases();
        foreach ($projects as $projectData) {
            $project = new Project();
            $project->setName($projectData['name']);
            $project->setDescription($projectData['description']);
            $project->setStartDate(new \DateTimeImmutable($projectData['startDate']));
            $project->setEndDate(new \DateTime($projectData['endDate']));
            $project->setStatus($projectData['status']);
            $projectTeam = $teamEntities[array_rand($teamEntities)];
            $project->setTeam($projectTeam);

            $manager->persist($project);

            // Users assigned to projects
            $assignedUsers = array_filter($userEntities, function($user) use ($projectTeam) {
                return $user->getTeams()->contains($projectTeam);
            });
            $assignedUsers = array_values($assignedUsers); // Re-index array

            $projectUsers = [];
            $userIndices = array_rand($assignedUsers, min(3, count($assignedUsers)));
            if (!is_array($userIndices)) {
                $userIndices = [$userIndices];
            }
            foreach ($userIndices as $userIndex) {
                $projectUser = new ProjectUser();
                $projectUser->setProject($project);
                $projectUser->setMember($assignedUsers[$userIndex]);
                $projectUser->setRole($roles[array_rand($roles)]);
                
                $manager->persist($projectUser);
                $projectUsers[] = $assignedUsers[$userIndex];

                // Add the member to the project
                $project->addMember($projectUser);
            }

            // Tasks assigned to projects
            $taskIndices = array_rand($tasks, min(count($tasks), rand(1, count($tasks))));
            if (!is_array($taskIndices)) {
                $taskIndices = [$taskIndices];
            }
            foreach ($taskIndices as $taskIndex) {
                $taskData = $tasks[$taskIndex];
                $task = new Task();
                $task->setName($taskData['name']);
                $task->setDescription($taskData['description']);
                $task->setStatus(TaskStatusEnum::cases()[array_rand(TaskStatusEnum::cases())]);
                $task->setPriority(TaskPriorityEnum::cases()[array_rand(TaskPriorityEnum::cases())]);
                $task->setDueDate(getRandomDate());
                $task->setProject($project);
                $task->setAssignedTo($projectUsers[array_rand($projectUsers)]);

                $manager->persist($task);

                // Comments for tasks
                $commentIndices = array_rand($comments, min(3, count($comments)));
                if (!is_array($commentIndices)) {
                    $commentIndices = [$commentIndices];
                }
                foreach ($commentIndices as $commentIndex) {
                    $comment = new Comment();
                    $comment->setContent($comments[$commentIndex]);
                    $comment->setAuthor($projectUsers[array_rand($projectUsers)]);
                    $comment->setTask($task);

                    $manager->persist($comment);
                }
            }

            // Comments for projects
            $commentIndices = array_rand($comments, min(3, count($comments)));
            if (!is_array($commentIndices)) {
                $commentIndices = [$commentIndices];
            }
            foreach ($commentIndices as $commentIndex) {
                $comment = new Comment();
                $comment->setContent($comments[$commentIndex]);
                $comment->setAuthor($projectUsers[array_rand($projectUsers)]);
                $comment->setProject($project);

                $manager->persist($comment);
            }
        }

        $manager->flush();
    }
}

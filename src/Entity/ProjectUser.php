<?php

namespace App\Entity;

use App\Repository\ProjectUserRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Enum\ProjectUserRoleEnum;

#[ORM\Entity(repositoryClass: ProjectUserRepository::class)]
class ProjectUser
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'projects')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $member = null;

    #[ORM\ManyToOne(inversedBy: 'members')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Project $project = null;

    #[ORM\Column(type: 'string', enumType: ProjectUserRoleEnum::class)]
    private ?ProjectUserRoleEnum $role = ProjectUserRoleEnum::MEMBER;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMember(): ?User
    {
        return $this->member;
    }

    public function setMember(?User $member): static
    {
        $this->member = $member;

        return $this;
    }

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): static
    {
        $this->project = $project;

        return $this;
    }

    public function getRole(): ?ProjectUserRoleEnum
    {
        return $this->role;
    }

    public function setRole(ProjectUserRoleEnum $role): static
    {
        $this->role = $role;

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Enum\ProjectStatusEnum;
use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjectRepository::class)]
class Project
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $startDate = null;

    #[ORM\Column]
    private ?\DateTime $endDate = null;

    #[ORM\Column(enumType: ProjectStatusEnum::class)]
    private ?ProjectStatusEnum $status = ProjectStatusEnum::PLANNED;

    #[ORM\ManyToOne(inversedBy: 'projects')]
    // #[ORM\JoinColumn(nullable: false)]
    private ?Team $team = null;

    /**
     * @var Collection<int, ProjectUser>
     */
    #[ORM\OneToMany(targetEntity: ProjectUser::class, mappedBy: 'project', orphanRemoval: true)]
    private Collection $members;

    /**
     * @var Collection<int, Task>
     */
    #[ORM\OneToMany(targetEntity: Task::class, mappedBy: 'project', orphanRemoval: true)]
    private Collection $tasks;

    /**
     * @var Collection<int, Comment>
     */
    #[ORM\OneToMany(targetEntity: Comment::class, mappedBy: 'project', cascade: ['persist', 'remove'])]
    private Collection $comments;

    public function __construct()
    {
        $this->members = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->tasks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate->setTime(0, 0, 0);

        if ($startDate < new \DateTime()) {
            $this->status = ProjectStatusEnum::IN_PROGRESS;
        }

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): static
    {
        $this->endDate = $endDate->setTime(0, 0, 0);

        if ($endDate < new \DateTime()) {
            $this->status = ProjectStatusEnum::COMPLETED;
        }

        return $this;
    }

    public function getStatus(): ?ProjectStatusEnum
    {
        return $this->status;
    }

    public function setStatus(ProjectStatusEnum $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getTeam(): ?Team
    {
        return $this->team;
    }

    public function setTeam(?Team $team): static
    {
        $this->team = $team;

        return $this;
    }

    /**
     * @return Collection<int, ProjectUser>
     */
    public function getMembers(): Collection
    {
        return $this->members;
    }

    public function addMember(ProjectUser $member): static
    {
        if (!$member->getMember()->getTeams()->contains($this->team)) {
            throw new \InvalidArgumentException('The user must belong to the same team as the project.');
        }

        if (!$this->members->contains($member)) {
            $this->members->add($member);
            $member->setProject($this);
        }

        return $this;
    }

    public function removeMember(ProjectUser $member): static
    {
        if ($this->members->removeElement($member)) {
            // set the owning side to null (unless already changed)
            if ($member->getProject() === $this) {
                $member->setProject(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Task>
     */
    public function getTasks(): Collection
    {
        return $this->tasks;
    }

    public function addTask(Task $task): static
    {
        if (!$this->tasks->contains($task)) {
            $this->tasks->add($task);
            $task->setProject($this);
        }

        return $this;
    }

    public function removeTask(Task $task): static
    {
        if ($this->tasks->removeElement($task)) {
            // set the owning side to null (unless already changed)
            if ($task->getProject() === $this) {
                $task->setProject(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): static
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setProject($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): static
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getProject() === $this) {
                $comment->setProject(null);
            }
        }

        return $this;
    }
}

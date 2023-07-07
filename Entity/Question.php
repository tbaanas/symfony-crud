<?php

namespace App\Entity;

use App\Repository\QuestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: QuestionRepository::class)]
class Question
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $title = null;

    #[ORM\Column(length: 2500)]
    #[Assert\NotBlank]
    private ?string $content = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ip = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $createdDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updateDate = null;

    #[ORM\Column]
    private bool $hidden = false;

    #[ORM\Column]
    private bool $accept = false;

    #[ORM\Column]
    private int $votesPlus = 0;

    #[ORM\Column]
    private int $votesMinus = 0;

    #[ORM\ManyToOne(cascade: ['persist'], inversedBy: 'questions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Categories $category = null;

    #[ORM\ManyToOne(inversedBy: 'questions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\OneToMany(mappedBy: 'question', targetEntity: QuestionComment::class)]
    private Collection $questionComments;

    #[ORM\OneToMany(mappedBy: 'question', targetEntity: QuestionRating::class)]
    private Collection $questionRatings;

    #[ORM\ManyToMany(targetEntity: Tag::class, mappedBy: 'Questions')]
    private Collection $tags;

    public function __construct()
    {
        $this->questionComments = new ArrayCollection();
        $this->questionRatings = new ArrayCollection();
        $this->tags = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getIp(): ?string
    {
        return $this->ip;
    }

    public function setIp(?string $ip): self
    {
        $this->ip = $ip;

        return $this;
    }

    public function getCreatedDate(): ?\DateTimeInterface
    {
        return $this->createdDate;
    }

    public function setCreatedDate(\DateTimeInterface $createdDate): self
    {
        $this->createdDate = $createdDate;

        return $this;
    }

    public function getUpdateDate(): ?\DateTimeInterface
    {
        return $this->updateDate;
    }

    public function setUpdateDate(?\DateTimeInterface $updateDate): self
    {
        $this->updateDate = $updateDate;

        return $this;
    }

    public function isHidden(): ?bool
    {
        return $this->hidden;
    }

    public function setHidden(bool $hidden): self
    {
        $this->hidden = $hidden;

        return $this;
    }

    public function isAccept(): ?bool
    {
        return $this->accept;
    }

    public function setAccept(bool $accept): self
    {
        $this->accept = $accept;

        return $this;
    }

    public function getVotesPlus(): ?int
    {
        return $this->votesPlus;
    }

    public function setVotesPlus(int $votesPlus): self
    {
        $this->votesPlus = $votesPlus;

        return $this;
    }

    public function getVotesMinus(): ?int
    {
        return $this->votesMinus;
    }

    public function setVotesMinus(int $votesMinus): self
    {
        $this->votesMinus = $votesMinus;

        return $this;
    }

    public function getCategory(): ?Categories
    {
        return $this->category;
    }

    public function setCategory(?Categories $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, QuestionComment>
     */
    public function getQuestionComments(): Collection
    {
        return $this->questionComments;
    }

    public function addQuestionComment(QuestionComment $questionComment): self
    {
        if (!$this->questionComments->contains($questionComment)) {
            $this->questionComments->add($questionComment);
            $questionComment->setQuestion($this);
        }

        return $this;
    }

    public function removeQuestionComment(QuestionComment $questionComment): self
    {
        if ($this->questionComments->removeElement($questionComment)) {
            // set the owning side to null (unless already changed)
            if ($questionComment->getQuestion() === $this) {
                $questionComment->setQuestion(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, QuestionRating>
     */
    public function getQuestionRatings(): Collection
    {
        return $this->questionRatings;
    }

    public function addQuestionRating(QuestionRating $questionRating): self
    {
        if (!$this->questionRatings->contains($questionRating)) {
            $this->questionRatings->add($questionRating);
            $questionRating->setQuestion($this);
        }

        return $this;
    }

    public function removeQuestionRating(QuestionRating $questionRating): self
    {
        if ($this->questionRatings->removeElement($questionRating)) {
            // set the owning side to null (unless already changed)
            if ($questionRating->getQuestion() === $this) {
                $questionRating->setQuestion(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Tag>
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags->add($tag);
            $tag->addQuestion($this);
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        if ($this->tags->removeElement($tag)) {
            $tag->removeQuestion($this);
        }

        return $this;
    }


}

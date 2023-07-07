<?php

namespace App\Entity;

use App\Repository\QuestionCommentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuestionCommentRepository::class)]
class QuestionComment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 500)]
    private ?string $content= null;

    #[ORM\ManyToOne(inversedBy: 'questionComments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Question $question = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $addDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $editDate = null;

    #[ORM\ManyToOne(inversedBy: 'questionComments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ip = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'childComment')]
    private ?self $parentComment = null;

    #[ORM\OneToMany(mappedBy: 'parentComment', targetEntity: self::class)]
    private Collection $childComment;

    #[ORM\OneToMany(mappedBy: 'questionComment', targetEntity: CommentRating::class)]
    private Collection $commentRatings;

    #[ORM\Column(nullable: true)]
    private ?int $votePlus = null;

    #[ORM\Column(nullable: true)]
    private ?int $voteMinus = null;

    public function __construct()
    {
        $this->childComment = new ArrayCollection();
        $this->commentRatings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getQuestion(): ?Question
    {
        return $this->question;
    }

    public function setQuestion(?Question $question): self
    {
        $this->question = $question;

        return $this;
    }

    public function getAddDate(): ?\DateTimeInterface
    {
        return $this->addDate;
    }

    public function setAddDate(\DateTimeInterface $addDate): self
    {
        $this->addDate = $addDate;

        return $this;
    }

    public function getEditDate(): ?\DateTimeInterface
    {
        return $this->editDate;
    }

    public function setEditDate(\DateTimeInterface $editDate): self
    {
        $this->editDate = $editDate;

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

    public function getIp(): ?string
    {
        return $this->ip;
    }

    public function setIp(?string $ip): self
    {
        $this->ip = $ip;

        return $this;
    }

    public function getParentComment(): ?self
    {
        return $this->parentComment;
    }

    public function setParentComment(?self $parentComment): self
    {
        $this->parentComment = $parentComment;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getChildComment(): Collection
    {
        return $this->childComment;
    }

    public function addChildComment(self $childComment): self
    {
        if (!$this->childComment->contains($childComment)) {
            $this->childComment->add($childComment);
            $childComment->setParentComment($this);
        }

        return $this;
    }

    public function removeChildComment(self $childComment): self
    {
        if ($this->childComment->removeElement($childComment)) {
            // set the owning side to null (unless already changed)
            if ($childComment->getParentComment() === $this) {
                $childComment->setParentComment(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CommentRating>
     */
    public function getCommentRatings(): Collection
    {
        return $this->commentRatings;
    }

    public function addCommentRating(CommentRating $commentRating): self
    {
        if (!$this->commentRatings->contains($commentRating)) {
            $this->commentRatings->add($commentRating);
            $commentRating->setQuestionComment($this);
        }

        return $this;
    }

    public function removeCommentRating(CommentRating $commentRating): self
    {
        if ($this->commentRatings->removeElement($commentRating)) {
            // set the owning side to null (unless already changed)
            if ($commentRating->getQuestionComment() === $this) {
                $commentRating->setQuestionComment(null);
            }
        }

        return $this;
    }

    public function getVotePlus(): ?int
    {
        return $this->votePlus;
    }

    public function setVotePlus(?int $votePlus): self
    {
        $this->votePlus = $votePlus;

        return $this;
    }

    public function getVoteMinus(): ?int
    {
        return $this->voteMinus;
    }

    public function setVoteMinus(?int $voteMinus): self
    {
        $this->voteMinus = $voteMinus;

        return $this;
    }
}

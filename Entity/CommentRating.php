<?php

namespace App\Entity;

use App\Repository\CommentRatingRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentRatingRepository::class)]
class CommentRating
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'commentRatings')]
    private ?QuestionComment $questionComment = null;

    #[ORM\ManyToOne(inversedBy: 'commentRatings')]
    private ?User $user = null;

    #[ORM\Column]
    private ?bool $vote = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestionComment(): ?QuestionComment
    {
        return $this->questionComment;
    }

    public function setQuestionComment(?QuestionComment $questionComment): self
    {
        $this->questionComment = $questionComment;

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

    public function isVote(): ?bool
    {
        return $this->vote;
    }

    public function setVote(bool $vote): self
    {
        $this->vote = $vote;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }
}

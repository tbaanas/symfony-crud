<?php

namespace App\Dto;

use Doctrine\Common\Collections\Collection;

class QuestionDto
{
    private ?int $id = null;

    private ?string $title = null;

    private ?string $content = null;

    private ?\DateTimeInterface $createdDate = null;

    private ?\DateTimeInterface $updateDate = null;

    private int $votesPlus = 0;

    private int $votesMinus = 0;

    private string $category;

    private string $user;

    private Collection $questionComments;

    private Collection $questionRatings;

    private Collection $tags;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): void
    {
        $this->content = $content;
    }

    public function getCreatedDate(): ?\DateTimeInterface
    {
        return $this->createdDate;
    }

    public function setCreatedDate(?\DateTimeInterface $createdDate): void
    {
        $this->createdDate = $createdDate;
    }

    public function getUpdateDate(): ?\DateTimeInterface
    {
        return $this->updateDate;
    }

    public function setUpdateDate(?\DateTimeInterface $updateDate): void
    {
        $this->updateDate = $updateDate;
    }

    public function getVotesPlus(): int
    {
        return $this->votesPlus;
    }

    public function setVotesPlus(int $votesPlus): void
    {
        $this->votesPlus = $votesPlus;
    }

    public function getVotesMinus(): int
    {
        return $this->votesMinus;
    }

    public function setVotesMinus(int $votesMinus): void
    {
        $this->votesMinus = $votesMinus;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function setCategory(string $category): void
    {
        $this->category = $category;
    }

    public function getUser(): string
    {
        return $this->user;
    }

    public function setUser(string $user): void
    {
        $this->user = $user;
    }

    public function getQuestionComments(): Collection
    {
        return $this->questionComments;
    }

    public function setQuestionComments(Collection $questionComments): void
    {
        $this->questionComments = $questionComments;
    }

    public function getQuestionRatings(): Collection
    {
        return $this->questionRatings;
    }

    public function setQuestionRatings(Collection $questionRatings): void
    {
        $this->questionRatings = $questionRatings;
    }

    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function setTags(Collection $tags): void
    {
        $this->tags = $tags;
    }
}

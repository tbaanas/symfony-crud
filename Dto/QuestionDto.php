<?php

namespace App\Dto;

use App\Entity\Categories;
use App\Entity\User;
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

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     */
    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string|null
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @param string|null $content
     */
    public function setContent(?string $content): void
    {
        $this->content = $content;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getCreatedDate(): ?\DateTimeInterface
    {
        return $this->createdDate;
    }

    /**
     * @param \DateTimeInterface|null $createdDate
     */
    public function setCreatedDate(?\DateTimeInterface $createdDate): void
    {
        $this->createdDate = $createdDate;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getUpdateDate(): ?\DateTimeInterface
    {
        return $this->updateDate;
    }

    /**
     * @param \DateTimeInterface|null $updateDate
     */
    public function setUpdateDate(?\DateTimeInterface $updateDate): void
    {
        $this->updateDate = $updateDate;
    }

    /**
     * @return int
     */
    public function getVotesPlus(): int
    {
        return $this->votesPlus;
    }

    /**
     * @param int $votesPlus
     */
    public function setVotesPlus(int $votesPlus): void
    {
        $this->votesPlus = $votesPlus;
    }

    /**
     * @return int
     */
    public function getVotesMinus(): int
    {
        return $this->votesMinus;
    }

    /**
     * @param int $votesMinus
     */
    public function setVotesMinus(int $votesMinus): void
    {
        $this->votesMinus = $votesMinus;
    }

    /**
     * @return string
     */
    public function getCategory(): string
    {
        return $this->category;
    }

    /**
     * @param string $category
     */
    public function setCategory(string $category): void
    {
        $this->category = $category;
    }

    /**
     * @return string
     */
    public function getUser(): string
    {
        return $this->user;
    }

    /**
     * @param string $user
     */
    public function setUser(string $user): void
    {
        $this->user = $user;
    }

    /**
     * @return Collection
     */
    public function getQuestionComments(): Collection
    {
        return $this->questionComments;
    }

    /**
     * @param Collection $questionComments
     */
    public function setQuestionComments(Collection $questionComments): void
    {
        $this->questionComments = $questionComments;
    }

    /**
     * @return Collection
     */
    public function getQuestionRatings(): Collection
    {
        return $this->questionRatings;
    }

    /**
     * @param Collection $questionRatings
     */
    public function setQuestionRatings(Collection $questionRatings): void
    {
        $this->questionRatings = $questionRatings;
    }

    /**
     * @return Collection
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    /**
     * @param Collection $tags
     */
    public function setTags(Collection $tags): void
    {
        $this->tags = $tags;
    }









}
<?php

namespace App\Dto;

use App\Entity\User;
use Doctrine\Common\Collections\Collection;

class ArticlesDto
{
    private ?int $tempId = null;

    private ?string $title = null;

    private ?string $content = null;

    private ?\DateTimeImmutable $createdAt = null;

    private ?\DateTimeImmutable $updatedAt = null;

    private ?User $author = null;

    private Collection $articleComments;

    private Collection $tags;

    public function setId(int $tempId): self
    {
        $this->tempId = $tempId;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->tempId;
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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return Collection<int, ArticleComment>
     */
    public function getArticleComments(): Collection
    {
        return $this->articleComments;
    }

    public function addArticleComment(ArticleComment $articleComment): self
    {
        if (!$this->articleComments->contains($articleComment)) {
            $this->articleComments->add($articleComment);
            $articleComment->setArticle($this);
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
            $tag->addArticle($this);
        }

        return $this;
    }
}

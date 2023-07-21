<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['username'], message: 'Login jest już zajęty')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Assert\NotBlank]
    private ?string $username = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    /**
     * @var string|null
     */
    #[\Symfony\Component\Serializer\Annotation\Ignore]
    private ?string $plainPassword;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $email = null;

    #[ORM\Column(type: 'boolean')]
    private $isVerified = false;

    #[ORM\Column]
    private ?bool $activate = true;

    #[ORM\Column]
    private ?bool $banned = false;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?UserDetails $UserDetails = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Question::class)]
    private Collection $questions;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: LoginHistory::class)]
    private Collection $loginHistories;

    #[ORM\OneToOne(mappedBy: 'user', cascade: ['persist', 'remove'])]
    private ?Warnings $warnings = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $ban_reason = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $banDate = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: QuestionComment::class)]
    private Collection $questionComments;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: QuestionRating::class)]
    private Collection $questionRatings;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: CommentRating::class)]
    private Collection $commentRatings;

    #[ORM\OneToMany(mappedBy: 'author', targetEntity: Articles::class)]
    private Collection $articles;

    #[ORM\OneToMany(mappedBy: 'author', targetEntity: ArticleComment::class)]
    private Collection $articleComments;

    #[ORM\OneToOne(mappedBy: 'user', cascade: ['persist', 'remove'])]
    private ?UserPoints $userPoint = null;

    public function __construct()
    {
        $this->questions = new ArrayCollection();
        $this->loginHistories = new ArrayCollection();
        $this->questionComments = new ArrayCollection();
        $this->questionRatings = new ArrayCollection();
        $this->commentRatings = new ArrayCollection();
        $this->articles = new ArrayCollection();
        $this->articleComments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(string $plainPassword): void
    {
        $this->plainPassword = $plainPassword;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function isActivate(): ?bool
    {
        return $this->activate;
    }

    public function setActivate(bool $activate): self
    {
        $this->activate = $activate;

        return $this;
    }

    public function isBanned(): ?bool
    {
        return $this->banned;
    }

    public function setBanned(bool $banned): self
    {
        $this->banned = $banned;

        return $this;
    }

    public function getUserDetails(): ?UserDetails
    {
        return $this->UserDetails;
    }

    public function setUserDetails(UserDetails $UserDetails): self
    {
        $this->UserDetails = $UserDetails;

        return $this;
    }

    /**
     * @return Collection<int, Question>
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    public function addQuestion(Question $question): self
    {
        if (!$this->questions->contains($question)) {
            $this->questions->add($question);
            $question->setUser($this);
        }

        return $this;
    }

    public function removeQuestion(Question $question): self
    {
        if ($this->questions->removeElement($question)) {
            // set the owning side to null (unless already changed)
            if ($question->getUser() === $this) {
                $question->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, LoginHistory>
     */
    public function getLoginHistories(): Collection
    {
        return $this->loginHistories;
    }

    public function addLoginHistory(LoginHistory $loginHistory): self
    {
        if (!$this->loginHistories->contains($loginHistory)) {
            $this->loginHistories->add($loginHistory);
            $loginHistory->setUser($this);
        }

        return $this;
    }

    public function removeLoginHistory(LoginHistory $loginHistory): self
    {
        if ($this->loginHistories->removeElement($loginHistory)) {
            // set the owning side to null (unless already changed)
            if ($loginHistory->getUser() === $this) {
                $loginHistory->setUser(null);
            }
        }

        return $this;
    }

    public function getWarnings(): ?Warnings
    {
        return $this->warnings;
    }

    public function setWarnings(?Warnings $warnings): self
    {
        // unset the owning side of the relation if necessary
        if (null === $warnings && null !== $this->warnings) {
            $this->warnings->setUser(null);
        }

        // set the owning side of the relation if necessary
        if (null !== $warnings && $warnings->getUser() !== $this) {
            $warnings->setUser($this);
        }

        $this->warnings = $warnings;

        return $this;
    }

    public function getBanReason(): ?string
    {
        return $this->ban_reason;
    }

    public function setBanReason(?string $ban_reason): self
    {
        $this->ban_reason = $ban_reason;

        return $this;
    }

    public function getBanDate(): ?\DateTimeInterface
    {
        return $this->banDate;
    }

    public function setBanDate(?\DateTimeInterface $banDate): self
    {
        $this->banDate = $banDate;

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
            $questionComment->setUser($this);
        }

        return $this;
    }

    public function removeQuestionComment(QuestionComment $questionComment): self
    {
        if ($this->questionComments->removeElement($questionComment)) {
            // set the owning side to null (unless already changed)
            if ($questionComment->getUser() === $this) {
                $questionComment->setUser(null);
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
            $questionRating->setUser($this);
        }

        return $this;
    }

    public function removeQuestionRating(QuestionRating $questionRating): self
    {
        if ($this->questionRatings->removeElement($questionRating)) {
            // set the owning side to null (unless already changed)
            if ($questionRating->getUser() === $this) {
                $questionRating->setUser(null);
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
            $commentRating->setUser($this);
        }

        return $this;
    }

    public function removeCommentRating(CommentRating $commentRating): self
    {
        if ($this->commentRatings->removeElement($commentRating)) {
            // set the owning side to null (unless already changed)
            if ($commentRating->getUser() === $this) {
                $commentRating->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Articles>
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Articles $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles->add($article);
            $article->setAuthor($this);
        }

        return $this;
    }

    public function removeArticle(Articles $article): self
    {
        if ($this->articles->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getAuthor() === $this) {
                $article->setAuthor(null);
            }
        }

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
            $articleComment->setAuthor($this);
        }

        return $this;
    }

    public function removeArticleComment(ArticleComment $articleComment): self
    {
        if ($this->articleComments->removeElement($articleComment)) {
            // set the owning side to null (unless already changed)
            if ($articleComment->getAuthor() === $this) {
                $articleComment->setAuthor(null);
            }
        }

        return $this;
    }

    public function getUserPoint(): ?UserPoints
    {
        return $this->userPoint;
    }

    public function setUserPoint(UserPoints $userPoint): self
    {
        // set the owning side of the relation if necessary
        if ($userPoint->getUser() !== $this) {
            $userPoint->setUser($this);
        }

        $this->userPoint = $userPoint;

        return $this;
    }
}

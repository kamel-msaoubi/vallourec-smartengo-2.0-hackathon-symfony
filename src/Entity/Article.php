<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 */
class Article
{
    /**
     * @Groups({ "article" })
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups({ "article" })
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @Groups({ "article" })
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $reference;

    /**
     * @Groups({ "article" })
     * @ORM\Column(type="text", nullable=true)
     */
    private $content;

    /**
     * @Groups({ "article" })
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $draft;

    /**
     * @Groups({ "article" })
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    /**
     * @Groups({ "article" })
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $updatedAt;

    /**
     * @Groups({ "article" })
     * @ORM\ManyToMany(targetEntity=Tag::class, mappedBy="articles")
     */
    private $tags;

    /**
     * @Groups({ "article" })
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="articles")
     */
    private $comments;

    /**
     * @Groups({ "article" })
     * @ORM\OneToMany(targetEntity=Reaction::class, mappedBy="articles")
     */
    private $reactions;

    /**
     * @Groups({ "article" })
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="articles")
     */
    private $users;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->reactions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(?string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getDraft(): ?bool
    {
        return $this->draft;
    }

    public function setDraft(?bool $draft): self
    {
        $this->draft = $draft;

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

    /**
     * @return Collection|Tag[]
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
            $tag->addArticle($this);
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        if ($this->tags->removeElement($tag)) {
            $tag->removeComment($this);
        }

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $Comment): self
    {
        if (!$this->Comments->contains($Comment)) {
            $this->Comments[] = $Comment;
            $Comment->setComments($this);
        }

        return $this;
    }

    public function removeComment(Comment $Comment): self
    {
        if ($this->Comments->removeElement($Comment)) {
            // set the owning side to null (unless already changed)
            if ($Comment->getComments() === $this) {
                $Comment->setComments(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Reaction[]
     */
    public function getReactions(): Collection
    {
        return $this->reactions;
    }

    public function addReaction(Reaction $reaction): self
    {
        if (!$this->reactions->contains($reaction)) {
            $this->reactions[] = $reaction;
            $reaction->setArticles($this);
        }

        return $this;
    }

    public function removeReaction(Reaction $reaction): self
    {
        if ($this->reactions->removeElement($reaction)) {
            // set the owning side to null (unless already changed)
            if ($reaction->getArticles() === $this) {
                $reaction->setArticles(null);
            }
        }

        return $this;
    }

    public function getUsers(): ?User
    {
        return $this->users;
    }

    public function setUsers(?User $users): self
    {
        $this->users = $users;

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\SharesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SharesRepository::class)
 *@ORM\Table(name="shares",uniqueConstraints={@ORM\UniqueConstraint(name="article_user", columns={"articles_id", "user_id"})})
 */
class Shares
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Article::class, inversedBy="shares")
     * @ORM\JoinColumn(nullable=false)
     */
    private $articles;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="shares")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="datetime")
     */
    private $sharedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getArticles(): ?Article
    {
        return $this->articles;
    }

    public function setArticles(?Article $articles): self
    {
        $this->articles = $articles;

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

    public function getSharedAt(): ?\DateTimeInterface
    {
        return $this->sharedAt;
    }

    public function setSharedAt(\DateTimeInterface $sharedAt): self
    {
        $this->sharedAt = $sharedAt;

        return $this;
    }
}

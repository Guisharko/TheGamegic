<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Deck", mappedBy="user")
     */
    private $decks;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\GameCard", mappedBy="UserId")
     */
    private $gameCards;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\GameCard", mappedBy="UserId")
     */
    private $userCards;

    public function __construct()
    {
        $this->decks = new ArrayCollection();
        $this->gameCards = new ArrayCollection();
        $this->userCards = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
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
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection|Deck[]
     */
    public function getDecks(): Collection
    {
        return $this->decks;
    }

    public function addDeck(Deck $deck): self
    {
        if (!$this->decks->contains($deck)) {
            $this->decks[] = $deck;
            $deck->addUser($this);
        }

        return $this;
    }

    public function removeDeck(Deck $deck): self
    {
        if ($this->decks->contains($deck)) {
            $this->decks->removeElement($deck);
            $deck->removeUser($this);
        }

        return $this;
    }

    /**
     * @return Collection|GameCard[]
     */
    public function getGameCards(): Collection
    {
        return $this->gameCards;
    }

    public function addGameCard(GameCard $gameCard): self
    {
        if (!$this->gameCards->contains($gameCard)) {
            $this->gameCards[] = $gameCard;
            $gameCard->addUserId($this);
        }

        return $this;
    }

    public function removeGameCard(GameCard $gameCard): self
    {
        if ($this->gameCards->contains($gameCard)) {
            $this->gameCards->removeElement($gameCard);
            $gameCard->removeUserId($this);
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUserCards()
    {
        return $this->userCards;
    }

    /**
     * @param mixed $userCards
     */
    public function setUserCards($userCards): void
    {
        $this->userCards = $userCards;
    }

}

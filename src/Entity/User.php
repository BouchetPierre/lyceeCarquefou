<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(
 *     fields={"email"},
 *     message="Cette adresse mail est déjà utilisée !!!"
 * )
 *
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
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email(message="Entrez une adresse valide !")
     */
    private $email;

     /**
     * @ORM\Column(type="string", length=255)
     */
    private $hash;

    /**
     * @Assert\EqualTo(propertyPath="hash", message="Erreur dans la confirmation du mot de passe !")
     */
    public $passwordConfirm;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Annonce", mappedBy="author", orphanRemoval=true)
     */
    private $annonces;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Role", mappedBy="users")
     */
    private $userRoles;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Message", mappedBy="author")
     */
    private $messages;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Repond", mappedBy="author")
     */
    private $reponds;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Repond", mappedBy="destinataire")
     */
    private $destiReponds;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\AdminPublication", mappedBy="author")
     */
    private $AdminPublications;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var \DateTime
     */
    private $passwordRequestedAt;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $token;

    /**
     * Get passwordRequestedAt
     */
    public function getPasswordRequestedAt()
    {
        return $this->passwordRequestedAt;
    }

    /**
     * Set passwordRequestedAt
     */
    public function setPasswordRequestedAt($passwordRequestedAt)
    {
        $this->passwordRequestedAt = $passwordRequestedAt;
        return $this;
    }

    /**
     * Get token
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set token
     */
    public function setToken($token)
    {
        $this->token = $token;
        return $this;
    }

    public function getFullName(){
        return "{$this->lastname} {$this->name}";
    }

    /**
     * Permet d'initialiser le slug
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     *
     * @return void
     */

    public function initializeSlug(){
        if(empty($this->slug)){
            $slugify = Slugify::create();
            $this->slug = $slugify->slugify($this->name.' '.$this->lastname);
        }
    }

    public function __construct()
    {
        $this->annonces = new ArrayCollection();
        $this->userRoles = new ArrayCollection();
        $this->messages = new ArrayCollection();
        $this->reponds = new ArrayCollection();
        $this->destiReponds = new ArrayCollection();
        $this->AdminPublications = new ArrayCollection();
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

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
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


    public function getHash(): ?string
    {
        return $this->hash;
    }

    public function setHash(string $hash): self
    {
        $this->hash = $hash;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return Collection|Annonce[]
     */
    public function getAnnonces(): Collection
    {
        return $this->annonces;
    }

    public function addAnnonce(Annonce $annonce): self
    {
        if (!$this->annonces->contains($annonce)) {
            $this->annonces[] = $annonce;
            $annonce->setAuthor($this);
        }

        return $this;
    }

    public function removeAnnonce(Annonce $annonce): self
    {
        if ($this->annonces->contains($annonce)) {
            $this->annonces->removeElement($annonce);
            // set the owning side to null (unless already changed)
            if ($annonce->getAuthor() === $this) {
                $annonce->setAuthor(null);
            }
        }

        return $this;
    }

    public function getRoles()
    {
        $roles = $this->userRoles->map(function($role){
            return $role->getTitle();
        })->toArray();

        $roles[]= 'ROLE_USER';

        return $roles;
    }

    public function getPassword()
    {
        return $this->hash;
    }

    public function getSalt()
    {
    }

    public function getUsername()
    {
        return $this->email;
    }

    public function eraseCredentials()
    {
    }

    /**
     * @return Collection|Role[]
     */
    public function getUserRoles(): Collection
    {
        return $this->userRoles;
    }

    public function addUserRole(Role $userRole): self
    {
        if (!$this->userRoles->contains($userRole)) {
            $this->userRoles[] = $userRole;
            $userRole->addUser($this);
        }

        return $this;
    }

    public function removeUserRole(Role $userRole): self
    {
        if ($this->userRoles->contains($userRole)) {
            $this->userRoles->removeElement($userRole);
            $userRole->removeUser($this);
        }

        return $this;
    }

    /**
     * @return Collection|Message[]
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages[] = $message;
            $message->setAuthor($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->messages->contains($message)) {
            $this->messages->removeElement($message);
            // set the owning side to null (unless already changed)
            if ($message->getAuthor() === $this) {
                $message->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Repond[]
     */
    public function getReponds(): Collection
    {
        return $this->reponds;
    }

    public function addRepond(Repond $repond): self
    {
        if (!$this->reponds->contains($repond)) {
            $this->reponds[] = $repond;
            $repond->setAuthor($this);
        }

        return $this;
    }

    public function removeRepond(Repond $repond): self
    {
        if ($this->reponds->contains($repond)) {
            $this->reponds->removeElement($repond);
            // set the owning side to null (unless already changed)
            if ($repond->getAuthor() === $this) {
                $repond->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Repond[]
     */
    public function getDestiReponds(): Collection
    {
        return $this->destiReponds;
    }

    public function addDestiRepond(Repond $destiRepond): self
    {
        if (!$this->destiReponds->contains($destiRepond)) {
            $this->destiReponds[] = $destiRepond;
            $destiRepond->setDestinataire($this);
        }

        return $this;
    }

    public function removeDestiRepond(Repond $destiRepond): self
    {
        if ($this->destiReponds->contains($destiRepond)) {
            $this->destiReponds->removeElement($destiRepond);
            // set the owning side to null (unless already changed)
            if ($destiRepond->getDestinataire() === $this) {
                $destiRepond->setDestinataire(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|AdminPublication[]
     */
    public function getAdminPublications(): Collection
    {
        return $this->AdminPublications;
    }

    public function addAdminPublication(AdminPublication $AdminPublication): self
    {
        if (!$this->AdminPublications->contains($AdminPublication)) {
            $this->AdminPublications[] = $AdminPublication;
            $AdminPublication->setAuthor($this);
        }

        return $this;
    }

    public function removeAdminPublication(AdminPublication $AdminPublication): self
    {
        if ($this->AdminPublications->contains($AdminPublication)) {
            $this->AdminPublications->removeElement($AdminPublication);
            // set the owning side to null (unless already changed)
            if ($AdminPublication->getAuthor() === $this) {
                $AdminPublication->setAuthor(null);
            }
        }

        return $this;
    }

}

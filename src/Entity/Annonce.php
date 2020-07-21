<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Self_;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AnnonceRepository")
 * @ORM\HasLifecycleCallbacks
 * @Vich\Uploadable
 */
class Annonce
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     *
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $phone;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $city;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $linkIn;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $country;

    /**
     * @ORM\Column(type="boolean")
     */
    private $emailOk;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $coverImage;

    /**
     * @var File|null
     * @Vich\UploadableField(mapping="annonce_image", fileNameProperty="coverImage")
     */
    private $imageFile;

     /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="annonces")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated_at;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Message", mappedBy="destinataire", cascade = {"remove"})
     */
    private $messages;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $typeScoolOne;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $specialOne;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $yearsOne;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $typeScoolTwo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $specialTwo;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $yearsTwo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $typeScoolThree;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $specialThree;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $yearsThree;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $profActivity;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $yourActivity;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $descriptionOne;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $descrisptionTwo;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $descriptionThree;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $descriptionActivity;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $categoryOne;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $categoryTwo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $categoryThree;

    public function __construct()
    {
        $this->messages = new ArrayCollection();
    }

        public function getId(): ?int
    {
        return $this->id;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

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

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getLinkIn(): ?string
    {
        return $this->linkIn;
    }

    public function setLinkIn(string $linkIn): self
    {
        $this->linkIn = $linkIn;

        return $this;
    }

    public function getCoverImage(): ?string
    {
        return $this->coverImage;
    }

    public function setCoverImage(?string $coverImage): void
    {
        $this->coverImage = $coverImage;

    }

    public function getEmailOk(): ?bool
    {
        return $this->emailOk;
    }

    public function setEmailOk(bool $emailOk): self
    {
        $this->emailOk = $emailOk;

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

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageFile(?File $imageFile =null): void
    {
        $this->imageFile = $imageFile;

        if(null !== $imageFile){
            $this->updated_at = new \DateTime('now');
        }
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

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
            $message->setDestinataire($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->messages->contains($message)) {
            $this->messages->removeElement($message);
            // set the owning side to null (unless already changed)
            if ($message->getDestinataire() === $this) {
                $message->setDestinataire(null);
            }
        }

        return $this;
    }

    public function getTypeScoolOne(): ?string
    {
        return $this->typeScoolOne;
    }

    public function setTypeScoolOne(?string $typeScoolOne): self
    {
        $this->typeScoolOne = $typeScoolOne;

        return $this;
    }

    public function getSpecialOne(): ?string
    {
        return $this->specialOne;
    }

    public function setSpecialOne(?string $specialOne): self
    {
        $this->specialOne = $specialOne;

        return $this;
    }

    public function getYearsOne(): ?\DateTimeInterface
    {
        return $this->yearsOne;
    }

    public function setYearsOne(?\DateTimeInterface $yearsOne): self
    {
        $this->yearsOne = $yearsOne;

        return $this;
    }

    public function getTypeScoolTwo(): ?string
    {
        return $this->typeScoolTwo;
    }

    public function setTypeScoolTwo(?string $typeScoolTwo): self
    {
        $this->typeScoolTwo = $typeScoolTwo;

        return $this;
    }

    public function getSpecialTwo(): ?string
    {
        return $this->specialTwo;
    }

    public function setSpecialTwo(?string $specialTwo): self
    {
        $this->specialTwo = $specialTwo;

        return $this;
    }

    public function getYearsTwo(): ?\DateTimeInterface
    {
        return $this->yearsTwo;
    }

    public function setYearsTwo(?\DateTimeInterface $yearsTwo): self
    {
        $this->yearsTwo = $yearsTwo;

        return $this;
    }

    public function getTypeScoolThree(): ?string
    {
        return $this->typeScoolThree;
    }

    public function setTypeScoolThree(?string $typeScoolThree): self
    {
        $this->typeScoolThree = $typeScoolThree;

        return $this;
    }

    public function getSpecialThree(): ?string
    {
        return $this->specialThree;
    }

    public function setSpecialThree(?string $specialThree): self
    {
        $this->specialThree = $specialThree;

        return $this;
    }

    public function getYearsThree(): ?\DateTimeInterface
    {
        return $this->yearsThree;
    }

    public function setYearsThree(?\DateTimeInterface $yearsThree): self
    {
        $this->yearsThree = $yearsThree;

        return $this;
    }

    public function getProfActivity(): ?bool
    {
        return $this->profActivity;
    }

    public function setProfActivity(?bool $profActivity): self
    {
        $this->profActivity = $profActivity;

        return $this;
    }

    public function getYourActivity(): ?string
    {
        return $this->yourActivity;
    }

    public function setYourActivity(?string $yourActivity): self
    {
        $this->yourActivity = $yourActivity;

        return $this;
    }

    public function getDescriptionOne(): ?string
    {
        return $this->descriptionOne;
    }

    public function setDescriptionOne(?string $descriptionOne): self
    {
        $this->descriptionOne = $descriptionOne;

        return $this;
    }

    public function getDescriptionTwo(): ?string
    {
        return $this->descrisptionTwo;
    }

    public function setDescriptionTwo(?string $descriptionTwo): self
    {
        $this->descriptionTwo = $descriptionTwo;

        return $this;
    }

    public function getDescriptionThree(): ?string
    {
        return $this->descriptionThree;
    }

    public function setDescriptionThree(?string $descriptionThree): self
    {
        $this->descriptionThree = $descriptionThree;

        return $this;
    }

    public function getDescriptionActivity(): ?string
    {
        return $this->descriptionActivity;
    }

    public function setDescriptionActivity(?string $descriptionActivity): self
    {
        $this->descriptionActivity = $descriptionActivity;

        return $this;
    }

    public function getCategoryOne(): ?string
    {
        return $this->categoryOne;
    }

    public function setCategoryOne(?string $categoryOne): self
    {
        $this->categoryOne = $categoryOne;

        return $this;
    }

    public function getCategoryTwo(): ?string
    {
        return $this->categoryTwo;
    }

    public function setCategoryTwo(?string $categoryTwo): self
    {
        $this->categoryTwo = $categoryTwo;

        return $this;
    }

    public function getCategoryThree(): ?string
    {
        return $this->categoryThree;
    }

    public function setCategoryThree(?string $categoryThree): self
    {
        $this->categoryThree = $categoryThree;

        return $this;
    }
}

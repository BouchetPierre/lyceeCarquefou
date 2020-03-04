<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PictureUserRepository")
 * @Vich\Uploadable
 */
class PictureUser
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var File|null
     * @Vich\UploadableField(mapping="annonce_image", fileNameProperty="coverImage")
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nameImage;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", inversedBy="pictureUser", cascade={"persist", "remove"})
     */
    private $userImage;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageFile(?File $imageFile =null): void
    {
        $this->imageFile = $imageFile;

        if(null !== $imageFile){
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getNameImage(): ?string
    {
        return $this->nameImage;
    }

    public function setNameImage(string $nameImage): void
    {
        $this->nameImage = $nameImage;

    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getUserImage(): ?User
    {
        return $this->userImage;
    }

    public function setUserImage(?User $userImage): self
    {
        $this->userImage = $userImage;

        return $this;
    }
}

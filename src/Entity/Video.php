<?php

namespace App\Entity;

use App\Repository\VideoRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: VideoRepository::class)]

/**
 * @ORM\Entity(repositoryClass=VideoRepository::class)
 */
class Video
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

      // @ORM\Column(type="string", length=255)
      #[ORM\Column(length: 255)]
      private ?string $titre = null;
  
      // @ORM\Column(type="text")
      #[ORM\Column(length: 255)]
      private ?string $description = null;

       // Stocke le chemin de la vidéo dans la base de données
      #[ORM\Column(length: 255, nullable: true)]
       private ?string $videoPath = null;
    
      // @ORM\Column(type="string", length=255)
      private ?File $videoFile = null;

      #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $createAd = null;
  
      // getter and setter methods
  
//    #[ORM\Column(type: 'datetime')]
//   private ?\DateTimeInterface $createAd = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreateAd(): ?\DateTimeInterface
    {
        return $this->createAd;
    }

    public function setCreateAd(\DateTimeInterface $createAd): self
    {
        $this->createAd = $createAd;

        return $this;
    }
        public function getTitre(): ?string
        {
            return $this->titre;
        }
    
        public function setTitre(string $titre): static
        {
            $this->titre = $titre;
            return $this;
        }
    
        public function getDescription(): ?string
        {
            return $this->description;
        }
    
        public function setDescription(string $description): static
        {
            $this->description = $description;
            return $this;
        }

        public function getVideoPath(): ?string
        {
            return $this->videoPath;
        }
    
        public function setVideoPath(?string $videoPath): static
        {
            $this->videoPath = $videoPath;
            return $this;
        }
    
        public function getVideoFile(): ?File
    {
        return $this->videoFile;
    }

    public function setVideoFile(?File $videoFile): static
    {
        $this->videoFile = $videoFile;
        return $this;
    }
    
        // You can add lifecycle callbacks to handle the video upload, like preUpload, etc.
    
}

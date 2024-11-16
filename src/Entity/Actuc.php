<?php

// src/Entity/Actuc.php

namespace App\Entity;

use App\Repository\ActucRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ActucRepository::class)]
class Actuc 
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(type: 'json', nullable: true)]
    private array $categorie = [];

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $imagePath = null; // Chemin relatif de l'image dans le dossier de téléchargement

    // #[ORM\Column(type: 'datetime')]
    // private ?\DateTimeInterface $createAd = null;


    // public function __construct()
    // {
    //     // Initialiser la valeur de create_ad
    //     $this->create_ad = new \DateTime(); // Ou une autre valeur si nécessaire
    // }
    // Getters et Setters
    public function getId(): ?int
    {
        return $this->id;
    }
    // public function getCreateAd(): ?\DateTimeInterface
    // {
    //     return $this->createAd;
    // }

    // public function setCreateAd(\DateTimeInterface $createAd): self
    // {
    //     $this->createAd = $createAd;

    //     return $this;
    // }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getCategorie(): array
    {
        return $this->categorie;
    }

    public function setCategorie(array $categorie): self
    {
        $this->categorie = $categorie;
        return $this;
    }

    public function getImagePath(): ?string
    {
        return $this->imagePath;
    }

    public function setImagePath(?string $imagePath): self
    {
        $this->imagePath = $imagePath;
        return $this;
    }
}

<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity]
class Appointement
{

   
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;



    #[Assert\NotBlank(message: 'Le nom ne peut pas être vide.')]
    #[Assert\Regex(
        pattern: '/^[A-Za-zÀ-ÿ\s]+$/u',
        message: 'Le nom ne peut contenir que des lettres.'
    )]
    #[ORM\Column(type: 'string', length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $email = null;

    #[Assert\NotBlank(message: 'Le sujet ne peut pas être vide.')]
    #[Assert\Regex(
        pattern: '/^[A-Za-zÀ-ÿ\s]+$/u',
        message: 'Le sujet ne peut contenir que des lettres.'
    )]
    #[ORM\Column(type: 'string', length: 255)]
    private ?string $subject = null;


    #[Assert\NotBlank(message: 'Le nom ne peut pas être vide.')]
    #[Assert\Regex(
        pattern: '/^[A-Za-zÀ-ÿ\s]+$/u',
        message: 'Le nom ne peut contenir que des lettres.'
    )]
    #[ORM\Column(type: 'text')]
    private ?string $message = null;

    // Getters and setters
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): self
    {
        $this->subject = $subject;
        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;
        return $this;
    }
}

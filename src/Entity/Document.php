<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DocumentRepository")
 */
class Document
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $categorie;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $documentName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $documentOriginalName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $documentExtension;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $documentSize;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Entreprise", inversedBy="documents")
     */
    private $entreprise;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $attachedTo;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $createdBy;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(string $categorie)
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getDocumentName()
    {
        return $this->documentName;
    }

    public function setDocumentName($documentName)
    {
        $this->documentName = $documentName;

        return $this;
    }

    public function getDocumentOriginalName()
    {
        return $this->documentOriginalName;
    }

    public function setDocumentOriginalName($documentOriginalName)
    {
        $this->documentOriginalName = $documentOriginalName;

        return $this;
    }

    public function getDocumentExtension()
    {
        return $this->documentExtension;
    }

    public function setDocumentExtension($documentExtension)
    {
        $this->documentExtension = $documentExtension;

        return $this;
    }

    public function getDocumentSize()
    {
        return $this->documentSize;
    }

    public function setDocumentSize($fileSize)
    {
        $this->documentSize = $documentSize;

        return $this;
    }

    public function getEntreprise()
    {
        return $this->entreprise;
    }

    public function setEntreprise($entreprise)
    {
        $this->entreprise = $entreprise;

        return $this;
    }

    public function getAttachedTo()
    {
        return $this->attachedTo;
    }

    public function setAttachedTo($attachedTo)
    {
        $this->attachedTo = $attachedTo;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;

        return $this;
    }
}

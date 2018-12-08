<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EntrepriseRepository")
 */
class Entreprise
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=9)
     */
    private $codeSiren;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Document", mappedBy="entreprise", cascade={"persist"}, orphanRemoval=true)
     */
    private $documents;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Contact", mappedBy="entreprise", cascade={"persist"}, orphanRemoval=true)
     */
    private $contacts;

    /**
     * @ORM\Column(type="string", length=4)
     */
    private $conventionCollective;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $trancheEffectifs;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbAdherents;

    /**
     * @ORM\Column(type="text")
     */
    private $notes;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $createdBy;

    /**
     * @ORM\Column(type="datetime")
     */
    private $modifiedAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $modifiedBy;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $deletedAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $deletedBy;

    public function __construct()
    {
        $this->documents = new ArrayCollection();
        $this->contacts = new ArrayCollection();
        $this->conventionCollective = '';
        $this->trancheEffectifs = '';
        $this->nbAdherents = 0;
        $this->notes = '';
        $this->createdAt = new \DateTime();
        $this->createdBy = '';
        $this->modifiedAt = new \DateTime();
        $this->modifiedBy = '';
    }

    public function getId()
    {
        return $this->id;
    }

    public function getCodeSiren()
    {
        return $this->codeSiren;
    }

    public function setCodeSiren($codeSiren)
    {
        $this->codeSiren = $codeSiren;

        return $this;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection|Document[]
     */
    public function getDocuments()
    {
        return $this->documents;
    }

    public function addDocument(Document $document)
    {
        if (!$this->documents->contains($document)) {
            $this->documents[] = $document;
            $document->setEntreprise($this);
        }

        return $this;
    }

    public function removeDocument(Document $document)
    {
        if ($this->documents->contains($document)) {
            $this->documents->removeElement($document);
            // set the owning side to null (unless already changed)
            if ($document->getEntreprise() === $this) {
                $document->setEntreprise(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Contact[]
     */
    public function getContacts()
    {
        return $this->contacts;
    }

    public function addContact(Contact $contact)
    {
        if (!$this->contacts->contains($contact)) {
            $this->contacts[] = $contact;
            $contact->setEntreprise($this);
        }

        return $this;
    }

    public function removeContact(Contact $contact)
    {
        if ($this->contacts->contains($contact)) {
            $this->contacts->removeElement($contact);
            // set the owning side to null (unless already changed)
            if ($contact->getEntreprise() === $this) {
                $contact->setEntreprise(null);
            }
        }

        return $this;
    }

    public function getConventionCollective()
    {
        return $this->conventionCollective;
    }

    public function setConventionCollective($conventionCollective)
    {
        $this->conventionCollective = $conventionCollective;

        return $this;
    }

    public function getTrancheEffectifs()
    {
        return $this->trancheEffectifs;
    }

    public function setTrancheEffectifs($trancheEffectifs)
    {
        $this->trancheEffectifs = $trancheEffectifs;

        return $this;
    }

    public function getNbAdherents()
    {
        return $this->nbAdherents;
    }

    public function setNbAdherents($nbAdherents)
    {
        $this->nbAdherents = $nbAdherents;

        return $this;
    }

    public function getNotes()
    {
        return $this->notes;
    }

    public function setNotes($notes)
    {
        $this->notes = $notes;

        return $this;
    }

    public function getCreatedAt()
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

    public function getModifiedAt()
    {
        return $this->modifiedAt;
    }

    public function setModifiedAt(\DateTimeInterface $modifiedAt)
    {
        $this->modifiedAt = $modifiedAt;

        return $this;
    }

    public function getModifiedBy()
    {
        return $this->modifiedBy;
    }

    public function setModifiedBy($modifiedBy)
    {
        $this->modifiedBy = $modifiedBy;

        return $this;
    }

    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(\DateTimeInterface $deletedAt)
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    public function getDeletedBy()
    {
        return $this->deletedBy;
    }

    public function setDeletedBy(string $deletedBy)
    {
        $this->deletedBy = $deletedBy;

        return $this;
    }
}

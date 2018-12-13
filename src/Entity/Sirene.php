<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * 
 */
class Sirene
{
    /**
     * 
     */
    private $id;

    /**
     * 
     */
    private $critere;

    /**
     * 
     */
    private $codeSiren;

    /**
     * 
     */
    private $unitelegale;

    /**
     * 
     */
    private $etablissements;

    public function __construct()
    {
        $this->etablissements = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getCritere()
    {
        return $this->critere;
    }

    public function setCritere($critere)
    {
        $this->critere = $critere;

        return $this;
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

    /**
     * Get the value of unitelegale
     */ 
    public function getUnitelegale()
    {
        return $this->unitelegale;
    }

    /**
     * Set the value of unitelegale
     *
     * @return  self
     */ 
    public function setUnitelegale(SireneUniteLegale $unitelegale)
    {
        $this->unitelegale = $unitelegale;

        return $this;
    }

    public function getEtablissements()
    {
        return $this->etablissements;
    }

    public function addEtablissement(SireneEtablissement $etablissement)
    {
        if (!$this->etablissements->contains($etablissement)) {
            $this->etablissements[] = $etablissement;
        }

        return $this;
    }
}

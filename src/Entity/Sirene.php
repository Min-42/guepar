<?php

namespace App\Entity;

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
        $this->etablissements = [];
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

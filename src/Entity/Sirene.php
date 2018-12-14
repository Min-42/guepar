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
    private $adresseSiege;

    /**
     * 
     */
    private $etablissements;

    /**
     * 
     */
    private $nbEtablissementsActifs;

    /**
     * 
     */
    private $nbEtablissementsFermés;

    public function __construct()
    {
        $this->etablissements = new ArrayCollection();
        $this->nbEtablissementsActifs = 0;
        $this->nbEtablissementsFermés = 0;
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

    /**
     * Get the value of adresseSiege
     */ 
    public function getAdresseSiege()
    {
        return $this->adresseSiege;
    }

    /**
     * Set the value of adresseSiege
     *
     * @return  self
     */ 
    public function setAdresseSiege(SireneAdresse $adresseSiege)
    {
        $this->adresseSiege = $adresseSiege;

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

    /**
     * Get the value of nbEtablissementsActifs
     */ 
    public function getNbEtablissementsActifs()
    {
        return $this->nbEtablissementsActifs;
    }

    /**
     * Set the value of nbEtablissementsActifs
     *
     * @return  self
     */ 
    public function setNbEtablissementsActifs($nbEtablissementsActifs)
    {
        $this->nbEtablissementsActifs = $nbEtablissementsActifs;

        return $this;
    }

    /**
     * Increment the value of nbEtablissementsActifs
     *
     * @return  self
     */ 
    public function incrementNbEtablissementsActifs()
    {
        $this->nbEtablissementsActifs += 1;

        return $this;
    }

    /**
     * Get the value of nbEtablissementsFermés
     */ 
    public function getNbEtablissementsFermés()
    {
        return $this->nbEtablissementsFermés;
    }

    /**
     * Set the value of nbEtablissementsFermés
     *
     * @return  self
     */ 
    public function setNbEtablissementsFermés($nbEtablissementsFermés)
    {
        $this->nbEtablissementsFermés = $nbEtablissementsFermés;

        return $this;
    }

    /**
     * Increment the value of nbEtablissementsFermés
     *
     * @return  self
     */ 
    public function incrementNbEtablissementsFermés()
    {
        $this->nbEtablissementsFermés += 1;

        return $this;
    }
}

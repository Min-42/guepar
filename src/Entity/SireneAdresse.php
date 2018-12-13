<?php

namespace App\Entity;


/**
 * 
 */
class SireneAdresse
{
    /**
     * 
     */
    private $id;

    /**
     * 
     */
    private $complementAdresse;

    /**
     * 
     */
    private $numeroVoie;

    /**
     * 
     */
    private $indiceRepetition;

    /**
     * 
     */
    private $typeVoie;

    /**
     * 
     */
    private $libelleVoie;

    /**
     * 
     */
    private $codePostal;

    /**
     * 
     */
    private $libelleCommune;

    /**
     * 
     */
    private $libelleCommuneEtranger;

    /**
     * 
     */
    private $distributionSpeciale;

    /**
     * 
     */
    private $codeCommune;

    /**
     * 
     */
    private $codeCedex;

    /**
     * 
     */
    private $libelleCedex;

    /**
     * 
     */
    private $codePaysEtranger;

    /**
     * 
     */
    private $libellePaysEtranger;

    public function __construct($adresse)
    {
        $this->complementAdresse = $adresse['complementAdresseEtablissement'];
        $this->numeroVoie = $adresse['numeroVoieEtablissement'];
        $this->indiceRepetition = $adresse['indiceRepetitionEtablissement'];
        $this->typeVoie = $adresse['typeVoieEtablissement'];
        $this->libelleVoie = $adresse['libelleVoieEtablissement'];
        $this->codePostal = $adresse['codePostalEtablissement'];
        $this->libelleCommune = $adresse['libelleCommuneEtablissement'];
        $this->libelleCommuneEtranger = $adresse['libelleCommuneEtrangerEtablissement'];
        $this->distributionSpeciale = $adresse['distributionSpecialeEtablissement'];
        $this->codeCommune = $adresse['codeCommuneEtablissement'];
        $this->codeCedex = $adresse['codeCedexEtablissement'];
        $this->libelleCedex = $adresse['libelleCedexEtablissement'];
        $this->codePaysEtranger = $adresse['codePaysEtrangerEtablissement'];
        $this->libellePaysEtranger = $adresse['libellePaysEtrangerEtablissement'];
    }

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of complementAdresse
     */ 
    public function getComplementAdresse()
    {
        return $this->complementAdresse;
    }

    /**
     * Set the value of complementAdresse
     *
     * @return  self
     */ 
    public function setComplementAdresse($complementAdresse)
    {
        $this->complementAdresse = $complementAdresse;

        return $this;
    }

    /**
     * Get the value of numeroVoie
     */ 
    public function getNumeroVoie()
    {
        return $this->numeroVoie;
    }

    /**
     * Set the value of numeroVoie
     *
     * @return  self
     */ 
    public function setNumeroVoie($numeroVoie)
    {
        $this->numeroVoie = $numeroVoie;

        return $this;
    }

    /**
     * Get the value of indiceRepetition
     */ 
    public function getIndiceRepetition()
    {
        return $this->indiceRepetition;
    }

    /**
     * Set the value of indiceRepetition
     *
     * @return  self
     */ 
    public function setIndiceRepetition($indiceRepetition)
    {
        $this->indiceRepetition = $indiceRepetition;

        return $this;
    }

    /**
     * Get the value of typeVoie
     */ 
    public function getTypeVoie()
    {
        return $this->typeVoie;
    }

    /**
     * Set the value of typeVoie
     *
     * @return  self
     */ 
    public function setTypeVoie($typeVoie)
    {
        $this->typeVoie = $typeVoie;

        return $this;
    }

    /**
     * Get the value of libelleVoie
     */ 
    public function getLibelleVoie()
    {
        return $this->libelleVoie;
    }

    /**
     * Set the value of libelleVoie
     *
     * @return  self
     */ 
    public function setLibelleVoie($libelleVoie)
    {
        $this->libelleVoie = $libelleVoie;

        return $this;
    }

    /**
     * Get the value of codePostal
     */ 
    public function getCodePostal()
    {
        return $this->codePostal;
    }

    /**
     * Set the value of codePostal
     *
     * @return  self
     */ 
    public function setCodePostal($codePostal)
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    /**
     * Get the value of libelleCommune
     */ 
    public function getLibelleCommune()
    {
        return $this->libelleCommune;
    }

    /**
     * Set the value of libelleCommune
     *
     * @return  self
     */ 
    public function setLibelleCommune($libelleCommune)
    {
        $this->libelleCommune = $libelleCommune;

        return $this;
    }

    /**
     * Get the value of libelleCommuneEtranger
     */ 
    public function getLibelleCommuneEtranger()
    {
        return $this->libelleCommuneEtranger;
    }

    /**
     * Set the value of libelleCommuneEtranger
     *
     * @return  self
     */ 
    public function setLibelleCommuneEtranger($libelleCommuneEtranger)
    {
        $this->libelleCommuneEtranger = $libelleCommuneEtranger;

        return $this;
    }

    /**
     * Get the value of distributionSpeciale
     */ 
    public function getDistributionSpeciale()
    {
        return $this->distributionSpeciale;
    }

    /**
     * Set the value of distributionSpeciale
     *
     * @return  self
     */ 
    public function setDistributionSpeciale($distributionSpeciale)
    {
        $this->distributionSpeciale = $distributionSpeciale;

        return $this;
    }

    /**
     * Get the value of codeCommune
     */ 
    public function getCodeCommune()
    {
        return $this->codeCommune;
    }

    /**
     * Set the value of codeCommune
     *
     * @return  self
     */ 
    public function setCodeCommune($codeCommune)
    {
        $this->codeCommune = $codeCommune;

        return $this;
    }

    /**
     * Get the value of codeCedex
     */ 
    public function getCodeCedex()
    {
        return $this->codeCedex;
    }

    /**
     * Set the value of codeCedex
     *
     * @return  self
     */ 
    public function setCodeCedex($codeCedex)
    {
        $this->codeCedex = $codeCedex;

        return $this;
    }

    /**
     * Get the value of libelleCedex
     */ 
    public function getLibelleCedex()
    {
        return $this->libelleCedex;
    }

    /**
     * Set the value of libelleCedex
     *
     * @return  self
     */ 
    public function setLibelleCedex($libelleCedex)
    {
        $this->libelleCedex = $libelleCedex;

        return $this;
    }

    /**
     * Get the value of codePaysEtranger
     */ 
    public function getCodePaysEtranger()
    {
        return $this->codePaysEtranger;
    }

    /**
     * Set the value of codePaysEtranger
     *
     * @return  self
     */ 
    public function setCodePaysEtranger($codePaysEtranger)
    {
        $this->codePaysEtranger = $codePaysEtranger;

        return $this;
    }

    /**
     * Get the value of libellePaysEtranger
     */ 
    public function getLibellePaysEtranger()
    {
        return $this->libellePaysEtranger;
    }

    /**
     * Set the value of libellePaysEtranger
     *
     * @return  self
     */ 
    public function setLibellePaysEtranger($libellePaysEtranger)
    {
        $this->libellePaysEtranger = $libellePaysEtranger;

        return $this;
    }
}
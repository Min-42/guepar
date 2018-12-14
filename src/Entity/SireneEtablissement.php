<?php

namespace App\Entity;

/**
 * 
 */
class SireneEtablissement
{
    /**
     * 
     */
    private $id;

    /**
     * 
     */
    private $nic;

    /**
     * 
     */
    private $etatAdministratifEtablissement;

    /**
     * 
     */
    private $adresse;

    /**
     * 
     */
    private $trancheEffectifs;

    /**
     * 
     */
    private $anneEffectifs;

    /**
     * 
     */
    private $activitePrincipale;

    /**
     * 
     */
    private $nomenclatureActivitePrincipale;

    /**
     * 
     */
    private $etablissementSiege;

    /**
     * 
     */
    private $enseigne1;

    /**
     * 
     */
    private $enseigne2;

    /**
     * 
     */
    private $enseigne3;

    /**
     * 
     */
    private $denominationUsuelle;

    /**
     * 
     */
    private $caractereEmployeur;

    public function __construct($etablissement, $periode)
    {
        $this->nic = $etablissement['nic'];
        $this->etatAdministratifEtablissement = $periode['etatAdministratifEtablissement'];
        $this->trancheEffectifs = $etablissement['trancheEffectifsEtablissement'];
        $this->anneEffectifs = $etablissement['anneeEffectifsEtablissement'];
        $this->etablissementSiege = $etablissement['etablissementSiege'];
        $this->enseigne1 = $periode['enseigne1Etablissement'];
        $this->enseigne2 = $periode['enseigne2Etablissement'];
        $this->enseigne3 = $periode['enseigne3Etablissement'];
        $this->denominationUsuelle = $periode['denominationUsuelleEtablissement'];
        $this->activitePrincipale = $periode['activitePrincipaleEtablissement'];
        $this->nomenclatureActivitePrincipale = $periode['nomenclatureActivitePrincipaleEtablissement'];
        $this->caractereEmployeur = $periode['caractereEmployeurEtablissement'];
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
     * Get the value of nic
     */ 
    public function getNic()
    {
        return $this->nic;
    }

    /**
     * Set the value of nic
     *
     * @return  self
     */ 
    public function setNic($nic)
    {
        $this->nic = $nic;

        return $this;
    }

    /**
     * Get the value of etatAdministratifEtablissement
     */ 
    public function getEtatAdministratifEtablissement()
    {
        return $this->etatAdministratifEtablissement;
    }

    /**
     * Set the value of etatAdministratifEtablissement
     *
     * @return  self
     */ 
    public function setEtatAdministratifEtablissement($etatAdministratifEtablissement)
    {
        $this->etatAdministratifEtablissement = $etatAdministratifEtablissement;

        return $this;
    }

    /**
     * Get the value of adresse
     */ 
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set the value of adresse
     *
     * @return  self
     */ 
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get the value of trancheEffectifs
     */ 
    public function getTrancheEffectifs()
    {
        return $this->trancheEffectifs;
    }

    /**
     * Set the value of trancheEffectifs
     *
     * @return  self
     */ 
    public function setTrancheEffectifs($trancheEffectifs)
    {
        $this->trancheEffectifs = $trancheEffectifs;

        return $this;
    }

    /**
     * Get the value of anneEffectifs
     */ 
    public function getAnneEffectifs()
    {
        return $this->anneEffectifs;
    }

    /**
     * Set the value of anneEffectifs
     *
     * @return  self
     */ 
    public function setAnneEffectifs($anneEffectifs)
    {
        $this->anneEffectifs = $anneEffectifs;

        return $this;
    }

    /**
     * Get the value of activitePrincipale
     */ 
    public function getActivitePrincipale()
    {
        return $this->activitePrincipale;
    }

    /**
     * Set the value of activitePrincipale
     *
     * @return  self
     */ 
    public function setActivitePrincipale($activitePrincipale)
    {
        $this->activitePrincipale = $activitePrincipale;

        return $this;
    }

    /**
     * Get the value of nomenclatureActivitePrincipale
     */ 
    public function getNomenclatureActivitePrincipale()
    {
        return $this->nomenclatureActivitePrincipale;
    }

    /**
     * Set the value of nomenclatureActivitePrincipale
     *
     * @return  self
     */ 
    public function setNomenclatureActivitePrincipale($nomenclatureActivitePrincipale)
    {
        $this->nomenclatureActivitePrincipale = $nomenclatureActivitePrincipale;

        return $this;
    }

    /**
     * Get the value of etablissementSiege
     */ 
    public function getEtablissementSiege()
    {
        return $this->etablissementSiege;
    }

    /**
     * Set the value of etablissementSiege
     *
     * @return  self
     */ 
    public function setEtablissementSiege($etablissementSiege)
    {
        $this->etablissementSiege = $etablissementSiege;

        return $this;
    }

    /**
     * Get the value of enseigne1
     */ 
    public function getEnseigne1()
    {
        return $this->enseigne1;
    }

    /**
     * Set the value of enseigne1
     *
     * @return  self
     */ 
    public function setEnseigne1($enseigne1)
    {
        $this->enseigne1 = $enseigne1;

        return $this;
    }

    /**
     * Get the value of enseigne2
     */ 
    public function getEnseigne2()
    {
        return $this->enseigne2;
    }

    /**
     * Set the value of enseigne2
     *
     * @return  self
     */ 
    public function setEnseigne2($enseigne2)
    {
        $this->enseigne2 = $enseigne2;

        return $this;
    }

    /**
     * Get the value of enseigne3
     */ 
    public function getEnseigne3()
    {
        return $this->enseigne3;
    }

    /**
     * Set the value of enseigne3
     *
     * @return  self
     */ 
    public function setEnseigne3($enseigne3)
    {
        $this->enseigne3 = $enseigne3;

        return $this;
    }

    /**
     * Get the value of denominationUsuelle
     */ 
    public function getDenominationUsuelle()
    {
        return $this->denominationUsuelle;
    }

    /**
     * Set the value of denominationUsuelle
     *
     * @return  self
     */ 
    public function setDenominationUsuelle($denominationUsuelle)
    {
        $this->denominationUsuelle = $denominationUsuelle;

        return $this;
    }

    /**
     * Get the value of caractereEmployeur
     */ 
    public function getCaractereEmployeur()
    {
        return $this->caractereEmployeur;
    }

    /**
     * Set the value of caractereEmployeur
     *
     * @return  self
     */ 
    public function setCaractereEmployeur($caractereEmployeur)
    {
        $this->caractereEmployeur = $caractereEmployeur;

        return $this;
    }
}
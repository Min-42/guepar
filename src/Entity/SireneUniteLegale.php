<?php

namespace App\Entity;


/**
 * 
 */
class SireneUniteLegale
{
    /**
     * 
     */
    private $id;

    /**
     * 
     */
    private $denomination;

    /**
     * 
     */
    private $statut;

    /**
     * 
     */
    private $categorieJuridique;

    /**
     * 
     */
    private $sigle;

    /**
     * 
     */
    private $denominationUsuelle1;

    /**
     * 
     */
    private $denominationUsuelle2;

    /**
     * 
     */
    private $denominationUsuelle3;

    /**
     * 
     */
    private $activitePrincipale;

    /**
     * 
     */
    private $activitePrincipaleNomenclature;

    /**
     * 
     */
    private $identifiantAssociation;

    /**
     * 
     */
    private $economieSocialeSolidaire;

    /**
     * 
     */
    private $caractereEmployeur;

    /**
     * 
     */
    private $trancheEffectif;

    /**
     * 
     */
    private $anneeTrancheEffectif;

    /**
     * 
     */
    private $nicSiege;

    /**
     * 
     */
    private $categorieEntreprise;

    /**
     * 
     */
    private $anneeCategorieEntreprise;

    public function __construct($uniteLegale)
    {
        $this->denomination = $uniteLegale['denominationUniteLegale'];
        $this->statut = $uniteLegale['etatAdministratifUniteLegale'];
        $this->categorieJuridique = $uniteLegale['categorieJuridiqueUniteLegale'];
        $this->sigle = $uniteLegale['sigleUniteLegale'];
        $this->denominationUsuelle1 = $uniteLegale['denominationUsuelle1UniteLegale'];
        $this->denominationUsuelle2 = $uniteLegale['denominationUsuelle2UniteLegale'];
        $this->denominationUsuelle3 = $uniteLegale['denominationUsuelle3UniteLegale'];
        $this->activitePrincipale = $uniteLegale['activitePrincipaleUniteLegale'];
        $this->activitePrincipaleNomenclature = $uniteLegale['nomenclatureActivitePrincipaleUniteLegale'];
        $this->identifiantAssociation = $uniteLegale['identifiantAssociationUniteLegale'];
        $this->economieSocialeSolidaire = $uniteLegale['economieSocialeSolidaireUniteLegale'];
        $this->caractereEmployeur = $uniteLegale['caractereEmployeurUniteLegale'];
        $this->trancheEffectif = $uniteLegale['trancheEffectifsUniteLegale'];
        $this->anneeTrancheEffectif = $uniteLegale['anneeEffectifsUniteLegale'];
        $this->nicSiege = $uniteLegale['nicSiegeUniteLegale'];
        $this->categorieEntreprise = $uniteLegale['categorieEntreprise'];
        $this->anneeCategorieEntreprise = $uniteLegale['anneeCategorieEntreprise'];
    }

    public function getId()
    {
        return $this->id;
    }

    public function getDenomination()
    {
        return $this->denomination;
    }

    public function setDenomination($denomination)
    {
        $this->denomination = $denomination;

        return $this;
    }

    public function getStatut()
    {
        return $this->statut;
    }

    public function setStatut($statut)
    {
        $this->statut = $statut;

        return $this;
    }

    public function getCategorieJuridique()
    {
        return $this->categorieJuridique;
    }

    public function setCategorieJuridique($categorieJuridique)
    {
        $this->categorieJuridique = $categorieJuridique;

        return $this;
    }

    public function getSigle()
    {
        return $this->sigle;
    }

    public function setSigle($sigle)
    {
        $this->sigle = $sigle;

        return $this;
    }

    public function getDenominationUsuelle1()
    {
        return $this->denominationUsuelle1;
    }

    public function setDenominationUsuelle1($denominationUsuelle1)
    {
        $this->denominationUsuelle1 = $denominationUsuelle1;

        return $this;
    }

    public function getDenominationUsuelle2()
    {
        return $this->denominationUsuelle2;
    }

    public function setDenominationUsuelle2($denominationUsuelle2)
    {
        $this->denominationUsuelle2 = $denominationUsuelle2;

        return $this;
    }

    public function getDenominationUsuelle3()
    {
        return $this->denominationUsuelle3;
    }

    public function setDenominationUsuelle3($denominationUsuelle3)
    {
        $this->denominationUsuelle3 = $denominationUsuelle3;

        return $this;
    }

    public function getActivitePrincipale()
    {
        return $this->activitePrincipale;
    }

    public function setActivitePrincipale($activitePrincipale)
    {
        $this->activitePrincipale = $activitePrincipale;

        return $this;
    }

    public function getActivitePrincipaleNomenclature()
    {
        return $this->activitePrincipaleNomenclature;
    }

    public function setActivitePrincipaleNomenclature($activitePrincipaleNomenclature)
    {
        $this->activitePrincipaleNomenclature = $activitePrincipaleNomenclature;

        return $this;
    }

    public function getIdentifiantAssociation()
    {
        return $this->identifiantAssociation;
    }

    public function setIdentifiantAssociation($identifiantAssociation)
    {
        $this->identifiantAssociation = $identifiantAssociation;

        return $this;
    }

    public function getEconomieSocialeSolidaire()
    {
        return $this->economieSocialeSolidaire;
    }

    public function setEconomieSocialeSolidaire($economieSocialeSolidaire)
    {
        $this->economieSocialeSolidaire = $economieSocialeSolidaire;

        return $this;
    }

    public function getCaractereEmployeur()
    {
        return $this->caractereEmployeur;
    }

    public function setCaractereEmployeur($caractereEmployeur)
    {
        $this->caractereEmployeur = $caractereEmployeur;

        return $this;
    }

    public function getTrancheEffectif()
    {
        return $this->trancheEffectif;
    }

    public function setTrancheEffectif($trancheEffectif)
    {
        $this->trancheEffectif = $trancheEffectif;

        return $this;
    }

    public function getAnneeTrancheEffectif()
    {
        return $this->anneeTrancheEffectif;
    }

    public function setAnneeTrancheEffectif($anneeTrancheEffectif)
    {
        $this->anneeTrancheEffectif = $anneeTrancheEffectif;

        return $this;
    }

    public function getNicSiege()
    {
        return $this->nicSiege;
    }

    public function setNicSiege($nicSiege)
    {
        $this->nicSiege = $nicSiege;

        return $this;
    }

    public function getCategorieEntreprise()
    {
        return $this->categorieEntreprise;
    }

    public function setCategorieEntreprise($categorieEntreprise)
    {
        $this->categorieEntreprise = $categorieEntreprise;

        return $this;
    }

    public function getAnneeCategorieEntreprise()
    {
        return $this->anneeCategorieEntreprise;
    }

    public function setAnneeCategorieEntreprise($anneeCategorieEntreprise)
    {
        $this->anneeCategorieEntreprise = $anneeCategorieEntreprise;

        return $this;
    }
}

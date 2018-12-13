<?php

// src/Twig/AppExtension.php
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    public function getFilters()
    {
        return array(
            new TwigFilter('trancheEffectifs', array($this, 'trancheEffectifs')),
        );
    }

    /**
     * Conversion du code INSEE de la tranche d'effectifs en libellé
     */
    public function trancheEffectifs($codeTranche)
    {
        $valTranche = "inconnue";
        switch ($codeTranche) {
            case "NN" :
                $valTranche = "non employeur";
                break;
            case "00" :
                $valTranche = "0";
                break;
            case "01" :
                $valTranche = "1 ou 2";
                break;
            case "02" :
                $valTranche = "3 à 5";
                break;
            case "03" :
                $valTranche = "6 à 9";
                break;
            case "11" :
                $valTranche = "10 à 19";
                break;
            case "12" :
                $valTranche = "20 à 49";
                break;
            case "21" :
                $valTranche = "50 à 99";
                break;
            case "22" :
                $valTranche = "100 à 199";
                break;
            case "31" :
                $valTranche = "200 à 249";
                break;
            case "32" :
                $valTranche = "250 à 499";
                break;
            case "41" :
                $valTranche = "500 à 999";
                break;
            case "42" :
                $valTranche = "1 000 à 1 999";
                break;
            case "51" :
                $valTranche = "2 000 à 4 999";
                break;
            case "52" :
                $valTranche = "5 000 à 9 999";
                break;
            case "53" :
                $valTranche = "plus de 10 000";
                break;
        }

        return $valTranche;
    }
}
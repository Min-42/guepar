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
}

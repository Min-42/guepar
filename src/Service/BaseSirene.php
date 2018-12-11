<?php

// src/Service/Sirene.php
namespace App\Service;

class BaseSirene
{
    private $urlBase;

    public function __construct($jeton, $urlBase)
    {
        $this->jeton = $jeton;
        $this->urlBase = $urlBase;
    }

    public function ChargeSirene($CodeSiren)
    {
        $curl = curl_init($this->getUrlBase());
        $params = [
            'CURLOPT_URL' => $this->getUrlBase().'siren/'.$codeSiren,
            'CURLOPT_HTTPHEADER' => [
                'Accept:application/json',
                'Authorization: Bearer '.$this->getJeton(),
            ],
            'CURLOPT_RETURNTRANSFER' => 1,
            'CURLOPT_CONNECTTIMEOUT' => 30,
        ];
        curl_setopt_array($curl, $params);

        $result = curl_exec($curl);
        if (curl_error($curl)) {
            $error_msg = curl_error($curl);
dump($error_msg);
        } else {
dump($result);
        }
die();
        return $result;
    }

    public function ChercheEntreprise($nomEntreprise)
    {
        return true;
    }

    public function getJeton()
    {
        return $this->jeton;
    }

    public function getUrlBase()
    {
        return $this->urlBase;
    }
}
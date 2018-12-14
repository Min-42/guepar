<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

use App\Entity\Sirene;
use App\Entity\SireneUniteLegale;
use App\Entity\SireneEtablissement;
use App\Entity\SireneAdresse;
use App\Form\SireneType;
use App\Service\BaseSirene;

class SireneController extends AbstractController
{
    /**
     * @Route("/sirene/{codeSiren}", name="sirene_detail")
     * @Route("/sirene", name="sirene_recherche")
     */
    public function index($codeSiren = null, Request $request, SessionInterface $session)
    {
        $sirene = new Sirene();
        if ($codeSiren){
            $sirene->setCodeSiren($codeSiren);
        }
        $session->set('critereSirene', $codeSiren);

        $formRecherche = $this->createForm(SireneType::class, $sirene);
        $formRecherche->handleRequest($request);

        return $this->render('sirene/recherche.html.twig', [
            'formRecherche' => $formRecherche->createView(),
            'sirene' => $sirene,
        ]);
    }

    /**
     * @Route("/sirene/result/{codeSiren}", name="sirene_result")
     */
    public function resultatRecherche($codeSiren = null, SessionInterface $session) {
        // Aucun critère de recherche renseigné
        if (!$codeSiren) {
            return $this->render('sirene/resultat/rechercheVide.html.twig');
        }
        $session->set('critereSirene', $codeSiren);

        $typeRecherche = $this->quelCritere($codeSiren);
        if ($typeRecherche == "aucun") {
            return $this->render('sirene/resultat/rechercheVide.html.twig');
        }

        if ($typeRecherche == "Code siren") {
            $result = $this->executeRechercheEtablissements($codeSiren);
            
            // Si pas d'erreur curl
            //      récupérer en-tête sirene
            // Si erreur curl ou accès base Sirene
            //      Render message d'erreur

            $tabResult = json_decode($result['valeur'], true);
            $sirene = $this->extraiteInfoSirene($tabResult['etablissements']);

            return $this->render('sirene/resultat/rechercheCodeSiren.html.twig', [
                'sirene' => $sirene,
                'codeSiren' => $session->get('critereSirene'),
                'json' => $result['valeur'],
            ]);
        }

        $result = $this->executeRechercheUniteLegale($codeSiren);
        // Si pas d'erreur curl
        //      récupérer en-tête sirene
        // Si erreur curl ou accès base Sirene
        //      Render message d'erreur

        $tabResult = json_decode($result['valeur'], true);
        $retour = $this->extraiteListe($tabResult['etablissements']);

        return $this->render('sirene/resultat/rechercheLibelle.html.twig', [
            'retour' => $retour,
            'codeSiren' => $session->get('critereSirene'),
            'json' => $result['valeur'],
        ]);
}

    private function executeRechercheUniteLegale($codeSiren) {
        $curl = curl_init('https://api.insee.fr/entreprises/sirene/V3/siret?q=raisonSociale:'.$codeSiren);

        curl_setopt($curl, CURLOPT_HTTPHEADER,[
            'Accept:application/json',
            'Authorization: Bearer '.'321ca85d-eab7-313c-b10b-84f0305d28b6',
        ]);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $result['valeur'] = curl_exec($curl);
        $result['numErreur'] = curl_error($curl);
        $result['msgErreur'] = curl_errno($curl);
        curl_close($curl);

        return $result;
    }

    private function executeRechercheEtablissements($codeSiren) {
        $curl = curl_init('https://api.insee.fr/entreprises/sirene/V3/siret?q=siren:'.$codeSiren);

        curl_setopt($curl, CURLOPT_HTTPHEADER,[
            'Accept:application/json',
            'Authorization: Bearer '.'321ca85d-eab7-313c-b10b-84f0305d28b6',
        ]);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $result['valeur'] = curl_exec($curl);
        $result['numErreur'] = curl_error($curl);
        $result['msgErreur'] = curl_errno($curl);
        curl_close($curl);

        return $result;
    }

    private function quelCritere($codeSiren) {
        if ($codeSiren == "" || $codeSiren == null) {
            return "aucun";
        }
        if (is_numeric($codeSiren) && strlen($codeSiren) == 9) {
            return "Code siren";
        }
        return "libellé";
    }

    private function extraiteInfoSirene($valeurSirene) {
        $sirene = new Sirene();

        foreach ($valeurSirene as $SireneEtablissement) {
            $first=true;
            $actif = false;
            foreach ($SireneEtablissement['periodesEtablissement'] as $key => $periodeEtablissement) {
                if ($periodeEtablissement['dateFin'] == null) {
                    if ($periodeEtablissement['etatAdministratifEtablissement'] == "A") {
                        $sirene->incrementNbEtablissementsActifs();
                        $actif = true;
                    } else {
                        $sirene->incrementNbEtablissementsFermés();
                    }
                    $indicePeriode = $key;
                }
            }
            if ($actif) {
                if ($first){
                    $sirene->setCodeSiren($SireneEtablissement['siren']);
                    $sirene->setUniteLegale(new SireneUniteLegale($SireneEtablissement['uniteLegale']));
                    $first = false;
                }
                $sireneEtablissement = new SireneEtablissement($SireneEtablissement, $SireneEtablissement['periodesEtablissement'][$indicePeriode]);
                $adresseEtablissement = new SireneAdresse($SireneEtablissement['adresseEtablissement']);
                $sireneEtablissement->setAdresse($adresseEtablissement);
                $sirene->addEtablissement($sireneEtablissement);
                if ($sireneEtablissement->getEtablissementSiege()) {
                    $sirene->setAdresseSiege($adresseEtablissement);
                }
            }
        }
        return $sirene;
    }

    private function extraiteListe($tableau) {
        return print_r($tableau[0]);
        $sirenes = [];
        foreach ($tableau as $key => $sousTableau) {
            $sirenes[] = $this->extraiteInfoSirene($sousTableau);
        }
        return $sirenes;
    }
}

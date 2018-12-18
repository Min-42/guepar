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
            $sirenes = $this->extraiteInfoSirene($tabResult['etablissements']);

            return $this->render('sirene/resultat/rechercheCodeSiren.html.twig', [
                'sirene' => $sirene[0],
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
$sirenes = $this->extraiteInfoSirene($tabResult['etablissements']);
//        $retour = $this->extraiteListe($tabResult['etablissements']);

        return $this->render('sirene/resultat/rechercheLibelle.html.twig', [
            'sirenes' => $sirenes,
            'codeSiren' => $session->get('critereSirene'),
            'json' => $result['valeur'],
        ]);
}

    private function executeRechercheUniteLegale($codeSiren) {
        $curl = curl_init('https://api.insee.fr/entreprises/sirene/V3/siret?q=raisonSociale:'.$codeSiren);

        curl_setopt($curl, CURLOPT_HTTPHEADER,[
            'Accept:application/json',
            'Authorization: Bearer '.'499c4ef8-de32-3d87-8c9f-874a95061859',
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
            'Authorization: Bearer '.'499c4ef8-de32-3d87-8c9f-874a95061859',
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
        $sirenes = [];

        foreach ($valeurSirene as $SireneEtablissement) {
dump($SireneEtablissement);
            $sirene = new Sirene();
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
                $sirenes[] = $sirene;
            }
        }
dump($sirenes);
        return $sirenes;
    }

    private function extraiteListe($tableau) {
        $sirenes = [];
dump($tableau[0]);
$sirenes[] = $this->extraiteInfoSirene($tableau[0]);
return $sirenes;
        foreach ($tableau as $key => $sousTableau) {
dump($sousTableau);
            $sirenes[] = $this->extraiteInfoSirene($sousTableau);
        }
        return $sirenes;
    }
}

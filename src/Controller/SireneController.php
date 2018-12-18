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
            $urlINSEE = 'https://api.insee.fr/entreprises/sirene/V3/siret?q=siren:'.$codeSiren;
        }
        if ($typeRecherche == "Libellé") {
            $urlINSEE = 'https://api.insee.fr/entreprises/sirene/V3/siret?q=raisonSociale:'.$codeSiren;
        }
        $result = $this->executeRecherche($urlINSEE);
        // Si pas d'erreur curl
        //      récupérer en-tête sirene
        // Si erreur curl ou accès base Sirene
        //      Render message d'erreur

        $tabResult = json_decode($result['valeur'], true);
        $sirenes = $this->extraiteInfoSirene($tabResult['etablissements']);

        if ($typeRecherche == "Code siren") {
            return $this->render('sirene/resultat/rechercheCodeSiren.html.twig', [
                'sirene' => $sirenes[0],
                'codeSiren' => $session->get('critereSirene'),
                'json' => $result['valeur'],
            ]);
        }

        return $this->render('sirene/resultat/rechercheLibelle.html.twig', [
            'sirenes' => $sirenes,
            'codeSiren' => $session->get('critereSirene'),
            'json' => $result['valeur'],
        ]);
    }

    private function executeRecherche($urlINSEE) {
        $curl = curl_init($urlINSEE);

        curl_setopt($curl, CURLOPT_HTTPHEADER,[
            'Accept:application/json',
            'Authorization: Bearer '.'499c4ef8-de32-3d87-8c9f-874a95061859',
        ]);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        
        $result = [];
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
        return "Libellé";
    }

    private function extraiteInfoSirene($valeurSirene) {
        // Les établissements arrivent de l'INSEE dans un ordre aléatoire
        // ==> Construction des sirenes en tableau
        $tabSirene=[];
        foreach ($valeurSirene as $sireneEtablissement) {
            $codeS = $sireneEtablissement['siren'];
            if (!isset($tabSirene[$codeS])) {
                $tabSirene[$codeS] = [];
            }
//            $tabSirene[$codeS]['nic'] = $sireneEtablissement['nic'];
            $tabSirene[$codeS]['siege'] = $sireneEtablissement['etablissementSiege'];
            $tabSirene[$codeS]['uniteLegale'] = new SireneUniteLegale($sireneEtablissement['uniteLegale']);
            $tabSirene[$codeS]['adresse'] = new SireneAdresse($sireneEtablissement['adresseEtablissement']);
            $indicePeriode = -1;
            $dateMax = "1900-01-01";
            foreach ($sireneEtablissement['periodesEtablissement'] as $keyPeriode => $periodeEtablissement) {
                if ($periodeEtablissement['dateFin'] == null) {
                    $indicePeriode = $keyPeriode;
                    break;
                }
                if ($periodeEtablissement['dateFin']>$dateMax) {
                    $indicePeriode = $keyPeriode;
                }
            }
            if (!isset($tabSirene[$codeS]['etablissements'])){
                $tabSirene[$codeS]['etablissements'] = [];
            }
            $etab = new SireneEtablissement($sireneEtablissement, $sireneEtablissement['periodesEtablissement'][$indicePeriode]);
            $etab->setAdresse($tabSirene[$codeS]['adresse']);
            $tabSirene[$codeS]['etablissements'][] = $etab;
        }
        
        $sirenes=[];
        foreach ($tabSirene as $keySiren => $elemSirene) {
            $sirene = new Sirene();
            $sirene->setCodeSiren($keySiren);
            $sirene->setUnitelegale($elemSirene['uniteLegale']);
            if ($elemSirene['siege']) $sirene->setAdresseSiege($elemSirene['adresse']);
            foreach ($elemSirene['etablissements'] as $keyEtab => $etab) {
                if ($etab->getEtatAdministratifEtablissement()=="A"){
                    $sirene->addEtablissement($etab);
                }
                if ($etab->getEtatAdministratifEtablissement() == "F") $sirene->incrementNbEtablissementsFermés();
                else $sirene->incrementNbEtablissementsActifs();
            }
            $sirenes[] = $sirene;
        }
        return $sirenes;
//        $sirenes = [];
//        foreach ($valeurSirene as $SireneEtablissement) {
//            $sirene = new Sirene();
//            $first=true;
//            $actif = false;
//            foreach ($SireneEtablissement['periodesEtablissement'] as $key => $periodeEtablissement) {
//                if ($periodeEtablissement['dateFin'] == null) {
//                    if ($periodeEtablissement['etatAdministratifEtablissement'] == "A") {
//                        $sirene->incrementNbEtablissementsActifs();
//                        $actif = true;
//                    } else {
//                        $sirene->incrementNbEtablissementsFermés();
//                    }
//                    $indicePeriode = $key;
//                }
//            }
//            if ($actif) {
//                if ($first){
//                    $sirene->setCodeSiren($SireneEtablissement['siren']);
//                    $sirene->setUniteLegale(new SireneUniteLegale($SireneEtablissement['uniteLegale']));
//                    $first = false;
//                }
//                $sireneEtablissement = new SireneEtablissement($SireneEtablissement, $SireneEtablissement['periodesEtablissement'][$indicePeriode]);
//                $adresseEtablissement = new SireneAdresse($SireneEtablissement['adresseEtablissement']);
//                $sireneEtablissement->setAdresse($adresseEtablissement);
//                $sirene->addEtablissement($sireneEtablissement);
//                if ($sireneEtablissement->getEtablissementSiege()) {
//                    $sirene->setAdresseSiege($adresseEtablissement);
//                }
//                $sirenes[] = $sirene;
//            }
//        }
        return $sirenes;
    }
}

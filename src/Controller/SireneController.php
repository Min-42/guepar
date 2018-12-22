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
            return $this->render('sirene/resultat/rechercheErreur.html.twig', [
                'erreur' => -1,
                'message' => 'Veuillez saisir un critère et effectuer une recherche',
            ]);
        }
        $session->set('critereSirene', $codeSiren);

        // Selon le type de rescherche, constitution de l'URL
        $typeRecherche = $this->quelCritere($codeSiren);
        if ($typeRecherche == "aucun") return $this->render('sirene/resultat/rechercheVide.html.twig');
        if ($typeRecherche == "Code siren") $urlINSEE = 'https://api.insee.fr/entreprises/sirene/V3/siret?q=siren:'.$codeSiren.'&nombre=500';
        if ($typeRecherche == "Libellé") $urlINSEE = 'https://api.insee.fr/entreprises/sirene/V3/siret?q=raisonSociale:'.$codeSiren.'&nombre=500';

        // Appel de l'API INSEE
        $result = $this->executeRecherche($urlINSEE);
        // Site INSEE en maintenance
        if (strstr($result['valeur'], "<title>Maintenance - INSEE</title>")) {
            $result['numErreur'] = 199;
            $result['msgErreur'] = "A la suite d'une maintenance du site de l'INSEE, les informations sont momentanément indisponibles.";
        }
        if ($result['numErreur'] != 0) {
            return $this->render('sirene/resultat/rechercheErreur.html.twig', [
                'erreur' => $result['numErreur'],
                'message' => $result['msgErreur'],
            ]);
        }

        // Analyse de l'en-tête INSEE
        $result = $this->extraireEnTeteSirene(json_decode($result['valeur'], true)['header'], $result);
        if ($result['numErreur'] != 200) {
            // Si erreur curl ou accès base Sirene ==> Render message d'erreur
            return $this->render('sirene/resultat/rechercheErreur.html.twig', [
                'erreur' => $result['numErreur'],
                'message' => $result['msgErreur'],
            ]);
        }

        // Récupération des infos sirène sous forme de tableau d'objets Sirene
        $tabResult = json_decode($result['valeur'], true);
        $sirenes = $this->extraireInfoSirene($tabResult['etablissements']);

        // Restitution
        if ($typeRecherche == "Code siren") {
            return $this->render('sirene/resultat/rechercheCodeSiren.html.twig', [
                'sirene' => $sirenes[0],
            ]);
        }

        return $this->render('sirene/resultat/rechercheLibelle.html.twig', [
            'sirenes' => $sirenes,
        ]);
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

    private function executeRecherche($urlINSEE) {
        $curl = curl_init($urlINSEE);

        curl_setopt($curl, CURLOPT_HTTPHEADER,[
            'Accept:application/json',
            'Authorization: Bearer '.'d66a4595-c8c7-3337-93d3-5b8563a5ada0',
        ]);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        
        $result = [];
        $result['numErreur'] = 0;
        if (!$result['valeur'] = curl_exec($curl)) {
            $result['msgErreur'] = curl_error($curl);
            $result['numErreur'] = curl_errno($curl);
        }
        curl_close($curl);

        return $result;
    }

    private function extraireInfoSirene($valeurSirene) {
        // Les établissements arrivent de l'INSEE dans un ordre aléatoire
        // ==> Construction des sirenes en tableau
        $tabSirene=[];
        foreach ($valeurSirene as $sireneEtablissement) {
            $codeS = $sireneEtablissement['siren'];
            if (!isset($tabSirene[$codeS])) {
                $tabSirene[$codeS] = [];
            }
            $tabSirene[$codeS]['uniteLegale'] = new SireneUniteLegale($sireneEtablissement['uniteLegale']);
            if ($sireneEtablissement['uniteLegale']['sexeUniteLegale'] == null) $tabSirene[$codeS]['individuelle'] = true;
            else $tabSirene[$codeS]['individuelle'] = false;
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
            $etab->setAdresse(new SireneAdresse($sireneEtablissement['adresseEtablissement']));
            $etab->setEtablissementSiege($sireneEtablissement['etablissementSiege']);
            $tabSirene[$codeS]['etablissements'][] = $etab;
        }
//dump($tabSirene);
//die();
        $sirenes=[];
        foreach ($tabSirene as $keySiren => $elemSirene) {
            $sirene = new Sirene();
            $sirene->setCodeSiren($keySiren);
            $sirene->setUnitelegale($elemSirene['uniteLegale']);
            $sirene->setIndividuelle($elemSirene['individuelle']);
            foreach ($elemSirene['etablissements'] as $keyEtab => $etab) {
                if ($etab->getEtatAdministratifEtablissement()=="A"){
                    $sirene->addEtablissement($etab);
                }
                if ($etab->getEtatAdministratifEtablissement() == "F") $sirene->incrementNbEtablissementsFermés();
                else $sirene->incrementNbEtablissementsActifs();
                if ($etab->getNic() == $etab->getNicSiege()) $sirene->setAdresseSiege($etab->getAdresse());
            }
            $sirenes[] = $sirene;
        }
        return $sirenes;
    }

    function extraireEnTeteSirene($header, $result) {
        $result['numErreur'] = $header['statut'];
        $result['msgErreur'] = $header['message'];
        return $result;
    }
}

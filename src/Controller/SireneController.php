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
     * @Route("/sirene/{id}", name="sirene_detail")
     * @Route("/sirene", name="sirene_recherche")
     */
    public function index(Sirene $sirene = null, Request $request, SessionInterface $session)
    {
        if (!$sirene) {
            $sirene = new Sirene();
        }

        $formRecherche = $this->createForm(SireneType::class, $sirene);
        $formRecherche->handleRequest($request);

        if ($formRecherche->isSubmitted() && $formRecherche->isValid()) {
            $session->set('critereSirene', $sirene->getCritere());
        }

        return $this->render('sirene/recherche.html.twig', [
            'formRecherche' => $formRecherche->createView(),
            'sirene' => $sirene,
        ]);
    }

    /**
     * @Route("/sirene/result/{critere}", name="sirene_result")
     */
    public function resultatRecherche($critere = null, SessionInterface $session) {
dump($session->get('critereSirene'));
        // Aucun critère de recherche renseigné
        if (!$critere and !$session->get('critereSirene')) {
            return $this->render('sirene/resultat/rechercheVide.html.twig');
        }

        $typeRecherche = $this->quelCritere($critere);

        if ($typeRecherche == "aucun") {
            return $this->render('sirene/resultat/rechercheVide.html.twig');
        }

        if ($typeRecherche == "Code siren") {
            $result = $this->executeRechercheEtablissements($critere);
            
            // Si pas d'erreur curl
            //      récupérer en-tête sirene
            // Si erreur curl ou accès base Sirene
            //      Render message d'erreur

            $tabResult = json_decode($result['valeur'], true);
            $sirene = $this->extraiteInfoSirene($tabResult['etablissements']);

            return $this->render('sirene/resultat/rechercheCodeSiren.html.twig', [
                'sirene' => $sirene,
                'json' => $result['valeur'],
            ]);
        }

        $result = $this->executeRechercheUniteLegale($critere);
        //      Récupérer la liste trouvées
    }

    private function executeRechercheUniteLegale($critere) {
        $curl = curl_init('https://api.insee.fr/entreprises/sirene/V3/siren/'.$critere);

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

    private function executeRechercheEtablissements($critere) {
        $curl = curl_init('https://api.insee.fr/entreprises/sirene/V3/siret?q=siren:'.$critere);

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

    private function quelCritere($critere) {
        if ($critere == "" || $critere == null) {
            return "aucun";
        }
        if (is_numeric($critere) && strlen($critere) == 9) {
            return "Code siren";
        }
        return "libellé";
    }

    private function extraiteInfoSirene($valeurSirene) {
        $sirene = new Sirene();

        foreach ($valeurSirene as $SireneEtablissement) {
            $actif=false;
            $first=true;
            foreach ($SireneEtablissement['periodesEtablissement'] as $key => $periodeEtablissement) {
                if ($periodeEtablissement['etatAdministratifEtablissement'] == "A") {
                    $actif = true;
                    $indicePeriode = $key;
                    break;
                }
            }
            if ($actif) {
                if ($first){
                    $sirene->setCodeSiren($SireneEtablissement['siren']);
                    $sirene->setUniteLegale(new SireneUniteLegale($SireneEtablissement['uniteLegale']));
                    $first = false;
                }
                $sireneEtablissement = new SireneEtablissement($SireneEtablissement, $SireneEtablissement['periodesEtablissement'][$indicePeriode]);
                $sireneEtablissement->setAdresse(new SireneAdresse($SireneEtablissement['adresseEtablissement']));
                $sirene->addEtablissement($sireneEtablissement);
            }
        }
        return $sirene;
    }
}

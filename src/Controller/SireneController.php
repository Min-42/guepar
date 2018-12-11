<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Sirene;
use App\Entity\SireneUniteLegale;
use App\Form\SireneType;
use App\Service\BaseSirene;

class SireneController extends AbstractController
{
    /**
     * @Route("/sirene/{id}", name="sirene_detail")
     * @Route("/sirene", name="sirene_recherche")
     */
    public function index(Sirene $sirene = null, Request $request)
    {
        if (!$sirene) {
            $sirene = new Sirene();
        }

        $formRecherche = $this->createForm(SireneType::class, $sirene);
        $formRecherche->handleRequest($request);

        return $this->render('sirene/recherche.html.twig', [
            'formRecherche' => $formRecherche->createView(),
            'sirene' => $sirene,
        ]);
    }

    /**
     * @Route("/sirene/result", name="sirene_result")
     */
    public function resultatRecherche($critere = null) {
        $typeRecherche = $this->quelCritere($critere);

        if ($typeRecherche == "aucun") {
            return $this->render('sirene/resultat/rechercheVide.html.twig');
        }

        if ($typeRecherche == "Code siren") {
            $result = $this->executeRechercheEtablissements($critere);
            
            // Si pas d'erreur curl
            //      récupérer et analyser en-tête sirene
            // Si erreur curl ou accè_s base Sirene
            //      Render message d'erreur

            $tabResult = json_decode($result['valeur'], true);
            $codeSiren = $tabResult['etablissements'][0]['siren'];
            $sireneUniteLegale = new SireneUniteLegale($tabResult['etablissements'][0]['uniteLegale']);

            return $this->render('sirene/resultat/rechercheCodeSiren.html.twig', [
                'codeSiren' => $codeSiren,
                'sireneUniteLegale' => $sireneUniteLegale,
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
}

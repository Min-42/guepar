<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Entreprise;
use App\Form\EntrepriseType;
use App\Repository\EntrepriseRepository;

class EntrepriseController extends AbstractController
{
    /**
     * @Route("/entreprise/{id}", name="entreprise_detail")
     * @Route("/entreprise/new", name="entreprise_new")
     */
    public function index(Entreprise $entreprise = null, Request $request, ObjectManager $manager)
    {
        if (!$entreprise) {
            $entreprise = new Entreprise();
            $this->setDefault($entreprise);
        }

        $formDetail = $this->createForm(EntrepriseType::class, $entreprise);
        $formDetail->handleRequest($request);

        if ($formDetail->isSubmitted() && $formDetail->isValid()) {

            // Mise à jour de la base de données
            $manager->persist($entreprise);
            $manager->flush();
            return $this->redirectToRoute('entreprise_liste');
        }
        
        return $this->render('entreprise/detail.html.twig', [
            'formDetail' => $formDetail->createView(),
            'entreprise' => $entreprise,
        ]);
    }

    /**
     * @Route("/entreprise", name="entreprise_liste")
     */
    public function liste(EntrepriseRepository $repo)
    {
        $entreprises = $repo->findAll();

        return $this->render('entreprise/liste.html.twig', [
            'entreprises' => $entreprises,
        ]);
    }

    private function setDefault(Entreprise $entreprise) {
        if ($entreprise->getContacts() === null) $entreprise->setContacts('');
        if ($entreprise->getConventionCollective() === null) $entreprise->setConventionCollective('');
        if ($entreprise->getTrancheEffectifs() === null) $entreprise->setTrancheEffectifs('');
        if ($entreprise->getNbAdherents() === null) $entreprise->setNbAdherents(0);
        if ($entreprise->getNotes() === null) $entreprise->setNotes('');
        $entreprise->setCreatedAt(new \DateTime());
        $entreprise->setCreatedBy("Michel-Creat");
        $entreprise->setModifiedAt(new \DateTime());
        $entreprise->setModifiedBy("Michel-Creat");
    }
}

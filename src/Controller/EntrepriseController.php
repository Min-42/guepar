<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\File;

use App\Entity\Entreprise;
use App\Form\EntrepriseType;
use App\Repository\EntrepriseRepository;
use App\Service\FileUploader;

class EntrepriseController extends AbstractController
{
    /**
     * @Route("/entreprise/{id}", name="entreprise_detail")
     * @Route("/entreprise/new", name="entreprise_new")
     */
    public function index(Entreprise $entreprise = null, Request $request, ObjectManager $manager, FileUploader $uploader)
    {
        if (!$entreprise) {
            $entreprise = new Entreprise();
        } else {
            foreach ($entreprise->getDocuments() as $document) {
                $document->setDocumentName(
                    new File($this->getParameter('documentDirectory').'/'.$document->getDocumentName())
                );
            }
        }

        $formDetail = $this->createForm(EntrepriseType::class, $entreprise);
        $formDetail->handleRequest($request);

        if ($formDetail->isSubmitted() && $formDetail->isValid()) {
            // Gestion des documents rattachés
            foreach ($entreprise->getDocuments() as $document) {
                $file = $document->getDocumentName();
                if ($file) {
                    $fileInfo = $uploader->upload($file);
                    $document->setDocumentName($fileInfo['documentName']);
                    $document->setDocumentOriginalName($fileInfo['documentOriginalName']);
                    $document->setDocumentExtension($fileInfo['documentExtension']);
                    $document->setDocumentSize($fileInfo['documentSize']);
                    $document->setAttachedTo('Entreprise');
                    $document->setCreatedAt(new \DateTime());
                    $document->setCreatedBy("Michel-Creat");
                }
            }

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
}

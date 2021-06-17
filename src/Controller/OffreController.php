<?php

namespace App\Controller;

use App\Entity\Candidatures;
use App\Entity\Categorie;
use App\Entity\OffreDemploi;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;

class OffreController extends AbstractController
{
    /**
     * @Route("recruteur/offre", name="offre")
     */
    public function index(): Response
    {
        $recruteur = $this->getUser()->getRecruteur();
        $offres = $this->getDoctrine()->getRepository(OffreDemploi::class)->findByRecruteur($recruteur);
        dump($offres);
        return $this->render('recruteur/offre.html.twig', [
            'offres' => $offres,
        ]);
    }

    /**
     * @Route("recruteur/offre/new", name="new_offre")
     */
    public function new(HttpFoundationRequest $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $recruteur = $this->getUser()->getRecruteur();
        $categories = $this->getDoctrine()->getRepository(Categorie::class)->findByRecruteur($recruteur);
        $nom = $request->get('nom');
        $catid = $request->get('categorie');
        $description = $request->get('description');
        $recruteur = $this->getUser()->getRecruteur();
        $offredemploi = new OffreDemploi();
        dump($recruteur);
        if ($request->getMethod() == "POST") {
            $categorie = $this->getDoctrine()->getManager()->getRepository(Categorie::class)->find($catid);
            $offredemploi->setNom($nom);
            $offredemploi->setDescription($description);
            $offredemploi->setRecruteur($recruteur);
            $offredemploi->setCategorie($categorie);
            $offredemploi->setDate(new \DateTime('now'));
            $entityManager->persist($offredemploi);
            $entityManager->flush();
            $this->addFlash('success', 'Ajouter avec succée');
            return $this->redirectToRoute('new_offre');
        }
        return $this->render('recruteur/newoffre.html.twig', [
            'categories' => $categories
        ]);
    }


    /**
     * @Route("recruteur/offre/edit/{id}", name="edit_offre")
     */
    public function edit(int $id, HttpFoundationRequest $request): Response
    {
        $recruteur = $this->getUser()->getRecruteur();
        $categories = $this->getDoctrine()->getRepository(Categorie::class)->findByRecruteur($recruteur);
        $offre = $this->getDoctrine()->getManager()->getRepository(OffreDemploi::class)->find($id);

        $nom = $request->get('nom');
        $description = $request->get('description');
        $catid = $request->get('categorie');

        if ($request->getMethod() == "POST") {
            $categorie = $this->getDoctrine()->getManager()->getRepository(Categorie::class)->find($catid);
            $offre->setNom($nom);
            $offre->setDescription($description);
            $offre->setCategorie($categorie);
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Modifier avec succée');
            return $this->redirectToRoute('edit_offre', ['id' => $id]);
        }
        return $this->render('recruteur/editOffre.html.twig', [
            'offre' => $offre,
            'categories' => $categories
        ]);
    }


    /**
     * @Route("recruteur/offre/delete/{id}", name="delete_offre")
     */
    public function delete(int $id): Response
    {
        $offre = $this->getDoctrine()->getManager()->getRepository(OffreDemploi::class)->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($offre);
        $entityManager->flush();
        $this->addFlash('suprimée', 'Offre supprimée avec succée');
        return $this->redirectToRoute('offre');
    }
}

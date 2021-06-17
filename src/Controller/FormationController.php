<?php

namespace App\Controller;

use App\Entity\Formation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;


class FormationController extends AbstractController
{
    /**
     * @Route("/candidat/modifierformation/{id}", name="edit_formation")
     */
    public function editefrm(int $id, HttpFoundationRequest $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $formation = $entityManager->getRepository(Formation::class)->find($id);
        dump($formation);
        $ecole = $request->get('ecole');
        $diplome = $request->get('diplome');
        $annee = $request->get('annee');
        if ($request->getMethod() == "POST") {
            $formation->setEcole($ecole);
            $formation->setDiplome($diplome);
            $formation->setAnnee($annee);
            $entityManager->flush();
            $this->addFlash('success', 'Modifier avec succée');
            return $this->redirectToRoute('edit_formation', ['id' => $id]);
        }
        return $this->render('candidat/editform.html.twig', [
            'formation' => $formation,
        ]);
    }

    /**
     * @Route("/candidat/ajouterformation", name="new_formation")
     */
    public function addform(HttpFoundationRequest $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $candidat = $user->getCandidat();
        $formation = new Formation();
        $ecole = $request->get('ecole');
        $diplome = $request->get('diplome');
        $annee = $request->get('annee');
        if ($request->getMethod() == "POST") {
            $formation->setEcole($ecole);
            $formation->setDiplome($diplome);
            $formation->setAnnee($annee);
            $formation->setCandidat($candidat);
            $entityManager->persist($formation);
            $entityManager->flush();
            $this->addFlash('success', 'Ajouter avec succée');
            return $this->redirectToRoute('new_formation');
        }
        return $this->render('candidat/addformation.html.twig', [
            'formation' => $formation,
        ]);
    }

    /**
     * @Route("/candidat/deleteformation/{id}", name="delete_formation")
     */
    public function deliteform(int $id): Response
    {

        $entityManager = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $idu = $user->getId();
        $formation = $entityManager->getRepository(Formation::class)->find($id);
        $entityManager->remove($formation);
        $entityManager->flush();
        return $this->redirectToRoute('candidat_cv', ['id' => $idu]);
    }
}

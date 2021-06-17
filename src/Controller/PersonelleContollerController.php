<?php

namespace App\Controller;

use App\Entity\Personelle;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;


class PersonelleContollerController extends AbstractController
{
    /**
     * @Route("/candidat/ajouterpers", name="new_pers")
     */
    public function addpers(HttpFoundationRequest $request): Response
    {
        //add info pers
        $entityManager = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $candidat = $user->getCandidat();
        $personelle = new Personelle();
        $nom = $request->get('nom');

        if ($request->getMethod() == "POST") {
            $personelle->setNom($nom);

            $personelle->setCandidat($candidat);
            $entityManager->persist($personelle);
            $entityManager->flush();
            $this->addFlash('success', 'Ajouter avec succée');
            return $this->redirectToRoute('new_pro');
        }
        return $this->render('candidat/addper.html.twig', []);
    }

    /**
     * @Route("/candidat/modifierpers/{id}", name="edit_pro")
     */
    public function editepers(int $id, HttpFoundationRequest $request): Response
    {
        //edit info pers 
        $entityManager = $this->getDoctrine()->getManager();
        $personelle = $entityManager->getRepository(Personelle::class)->find($id);
        dump($personelle);
        $nom = $request->get('nom');

        if ($request->getMethod() == "POST") {
            $personelle->setNom($nom);
            $entityManager->flush();
            $this->addFlash('success', 'Modifier avec succée');
            return $this->redirectToRoute('edit_pro', ['id' => $id]);
        }
        return $this->render('candidat/editpers.html.twig', [
            'personelle' => $personelle,
        ]);
    }

    /**
     * @Route("/candidat/deletepers/{id}", name="delete_pers")
     */
    public function delitepers(int $id): Response
    {
        //delete

        $entityManager = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $idu = $user->getId();
        $personelle = $entityManager->getRepository(Personelle::class)->find($id);
        $entityManager->remove($personelle);
        $entityManager->flush();
        return $this->redirectToRoute('candidat_cv', ['id' => $idu]);
    }
}

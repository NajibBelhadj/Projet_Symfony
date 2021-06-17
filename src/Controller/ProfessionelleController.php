<?php

namespace App\Controller;

use App\Entity\Professionelle;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;


class ProfessionelleController extends AbstractController
{
    /**
     * @Route("/candidat/modifierpro/{id}", name="edit_pro")
     */
    public function editepro(int $id, HttpFoundationRequest $request): Response
    {
        // edit info pers
        $entityManager = $this->getDoctrine()->getManager();
        $professionelle = $entityManager->getRepository(Professionelle::class)->find($id);
        dump($professionelle);
        $nom = $request->get('nom');

        if ($request->getMethod() == "POST") {
            $professionelle->setNom($nom);
            $entityManager->flush();
            $this->addFlash('success', 'Modifier avec succée');
            return $this->redirectToRoute('edit_pro', ['id' => $id]);
        }
        return $this->render('candidat/editpro.html.twig', [
            'professionnelle' => $professionelle,
        ]);
    }

    /**
     * @Route("/candidat/ajouterpro", name="new_pro")
     */
    public function addpro(HttpFoundationRequest $request): Response
    {
        //add pers
        $entityManager = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $candidat = $user->getCandidat();
        $professionelle = new Professionelle();
        $nom = $request->get('nom');

        if ($request->getMethod() == "POST") {
            $professionelle->setNom($nom);

            $professionelle->setCandidat($candidat);
            $entityManager->persist($professionelle);
            $entityManager->flush();
            $this->addFlash('success', 'Ajouter avec succée');
            return $this->redirectToRoute('new_pro');
        }
        return $this->render('candidat/addpro.html.twig', []);
    }
    /**
     * @Route("/candidat/deletepro/{id}", name="delete_pro")
     */
    public function delitepro(int $id): Response
    {
        //delet info pers

        $entityManager = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $idu = $user->getId();
        $professionelle = $entityManager->getRepository(Professionelle::class)->find($id);
        $entityManager->remove($professionelle);
        $entityManager->flush();
        return $this->redirectToRoute('candidat_cv', ['id' => $idu]);
    }
}

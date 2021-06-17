<?php

namespace App\Controller;

use App\Entity\CenterInreret;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;

class CentreInteretController extends AbstractController
{
    /**
     * @Route("/candidat/ajoutecentre", name="new_centre")
     */
    public function addcentre(HttpFoundationRequest $request): Response
    {
        //ajouter cente dinteret
        $entityManager = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $candidat = $user->getCandidat();
        $centreinteret = new CenterInreret();
        $nom = $request->get('nom');

        if ($request->getMethod() == "POST") {
            $centreinteret->setNom($nom);

            $centreinteret->setCandidat($candidat);
            $entityManager->persist($centreinteret);
            $entityManager->flush();
            $this->addFlash('success', 'Ajouter avec succée');
            return $this->redirectToRoute('new_centre');
        }
        return $this->render('candidat/addcentre.html.twig', []);
    }

    /**
     * @Route("/candidat/modifiecentre/{id}", name="edit_centre")
     */
    public function editecentre(int $id, HttpFoundationRequest $request): Response
    {
        //edit centre dinterer
        $entityManager = $this->getDoctrine()->getManager();
        $centre = $entityManager->getRepository(CenterInreret::class)->find($id);
        dump($centre);
        $nom = $request->get('nom');

        if ($request->getMethod() == "POST") {
            $centre->setNom($nom);
            $entityManager->flush();
            $this->addFlash('success', 'Modifier avec succée');
            return $this->redirectToRoute('edit_centre', ['id' => $id]);
        }
        return $this->render('candidat/editcentre.html.twig', [
            'centre' => $centre,
        ]);
    }

    /**
     * @Route("/candidat/deletecentre/{id}", name="delete_centre")
     */
    public function delitecentre(int $id): Response
    {
        //delete centre
        $entityManager = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $idu = $user->getId();
        $centre = $entityManager->getRepository(CenterInreret::class)->find($id);
        $entityManager->remove($centre);
        $entityManager->flush();
        return $this->redirectToRoute('candidat_cv', ['id' => $idu]);
    }
}

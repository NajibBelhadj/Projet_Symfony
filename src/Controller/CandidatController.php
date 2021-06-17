<?php

namespace App\Controller;

use App\Entity\Candidatures;
use App\Entity\OffreDemploi;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;


class CandidatController extends AbstractController
{
    /**
     * @Route("/candidat/modifierinfo/{id}", name="modifierinfo")
     */
    public function infoGeneral(int $id, HttpFoundationRequest $request): Response
    {
        //info generale
        $nom = $request->get('nom');
        $prenom = $request->get('prenom');
        $images = $request->files->get('img');
        $qui_je_suis = $request->get('description');
        $adress = $request->get('adresse');
        $telephone = $request->get('tel');
        $facebook = $request->get('facebook');
        $twitter = $request->get('twitter');
        $link = $request->get('link');
        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository(User::class)->find($id);
        $candidat = $user->getCandidat();
        // On boucle sur les images
        dump($candidat);
        if ($images != null) {
            // On génère un nouveau nom de fichier
            $fichier = md5(uniqid()) . '.' . $images->guessExtension();
            // On copie le fichier dans le dossier uploads
            $images->move(
                $this->getParameter('images_directory'),
                $fichier
            );
            dump($images);
            $candidat->setImage($fichier);
        }
        if ($request->getMethod() == "POST") {
            $user->setNom($nom);
            $user->setPrenom($prenom);
            $candidat->setQuiJeSuis($qui_je_suis);
            $candidat->setAdresse($adress);
            $candidat->setTelephone($telephone);
            $candidat->setFacebook($facebook);
            $candidat->setTwitter($twitter);
            $candidat->setLinkedin($link);
            $candidat->setUser($user);
            $entityManager->flush();
            $this->addFlash('success', 'modifier avec succée');
            return $this->redirectToRoute('modifierinfo', ['id' => $id]);
        }
        return $this->render('candidat/infoGeneral.html.twig', [
            'user' => $user,
        ]);
    }
    /**
     * @Route("/candidat/postul/{id}", name="add_postul")
     */
    public function postulation(int $id): Response
    {
        //postilation
        $entityManager = $this->getDoctrine()->getManager();
        $offre = $this->getDoctrine()->getRepository(OffreDemploi::class)->find($id);
        $iduser = $this->getUser()->getId();
        $user = $this->getDoctrine()->getRepository(User::class)->find($iduser);
        dump($offre);
        $candidatures = $this->getDoctrine()->getRepository(Candidatures::class)->findByOffre($offre);
        if ($this->getUser()->getCandidat()->getNbPostulationAutorisee() > 0) {
            foreach ($candidatures as $can) {
                if ($can->getCandidat()->getId() == $iduser) {
                    $this->addFlash('err', 'vous avez deja postulée dans cette offre');
                    return $this->redirectToRoute('all_offre');
                }
            }
            $user->getCandidat()->setNbPostulationAutorisee($user->getCandidat()->getNbPostulationAutorisee() - 1);
            $candidature = new Candidatures();
            $candidature->setCandidat($this->getUser());
            $candidature->setOffre($offre);
            $candidature->setDate(new \DateTime('now'));
            $entityManager->persist($candidature);
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('success', 'vous avez postuler dans cette offre');
        } else {
            $this->addFlash('error', 'vous ne pouver pas postuler');
        }
        return $this->redirectToRoute('all_offre');
    }

    /**
     * @Route("/candidat/offre", name="all_offre")
     */
    public function offre(): Response
    {
        //show all offre
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }
        $offres = $this->getDoctrine()->getRepository(OffreDemploi::class)->findAll();
        dump($offres);

        return $this->render('candidat/alloffre.html.twig', [
            'offres' => $offres,

        ]);
    }

    /**
     * @Route("/candidat/candidateur", name="all_candidateurs")
     */
    public function candidateur(): Response
    {
        //show all candidateur
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        $candidature = $this->getDoctrine()->getRepository(Candidatures::class)->findByCandidat($this->getUser()->getId());
        dump($candidature);

        return $this->render('candidat/candidateur.html.twig', [
            'candidateur' => $candidature,

        ]);
    }

    /**
     * @Route("/admin/tablecandidat", name="candidat_index")
     */
    public function candidat(): Response
    {
        $liste = [];
        $candidats = $this->getDoctrine()->getRepository(User::class)->findAll();
        foreach ($candidats as $candidat) {
            if ($candidat->getRoles()[0] == "ROLE_CANDIDAT") {
                array_push($liste, $candidat);
            }
        }
        return $this->render('admin/tableCandidat.html.twig', [
            'candidats' => $liste
        ]);
    }

    /**
     * @Route("/admin/deletecandidat/{id}", name="candidat_delete")
     */
    public function deletecandidat(int $id): Response
    {
        $candidat = $this->getDoctrine()->getManager()->getRepository(User::class)->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($candidat);
        $entityManager->flush();
        $this->addFlash('suprimée', 'Candidat supprimée avec succée');
        return $this->redirectToRoute('candidat_index');
    }
}

<?php

namespace App\Controller;

use App\Entity\Candidatures;
use App\Entity\Recruteur;
use App\Entity\User;
use App\Entity\OffreDemploi;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;


class RecruteurController extends AbstractController
{
    /**
     * @Route("/admin/tablerecruteur", name="recruteur_index")
     */
    public function recruteur(): Response
    {
        $liste = [];
        $recruteurs = $this->getDoctrine()->getRepository(User::class)->findAll();
        foreach ($recruteurs as $recruteur) {
            if ($recruteur->getRoles()[0] == "ROLE_RECRUTEUR") {
                array_push($liste, $recruteur);
            }
        }
        return $this->render('admin/tableRecruteur.html.twig', [
            'recruteurs' => $liste
        ]);
    }

    /**
     * @Route("/admin/newRecruteur", name="recruteur_new")
     */
    public function newRecruteur(HttpFoundationRequest $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $cin = $request->get('cin');
        $nom = $request->get('nom');
        $prenom = $request->get('prenom');
        $email = $request->get('email');
        $password = $request->get('password');
        $confirm_password = $request->get('confirm_password');
        $responsabilitee = $request->get('responsabilitee');
        $sexe = $request->get('sexe');
        $tel = $request->get('telephone');

        $user = new User();
        $recruteur = new Recruteur();
        if ($request->getMethod() == "POST") {
            $users = $this->getDoctrine()->getRepository(User::class)->findAll();
            foreach ($users as $user) {
                if ($user->getEmail() == $email) {
                    $this->addFlash('error', 'Email already Exist');
                    return $this->redirectToRoute('recruteur_new');
                }
            }
            if ($password != $confirm_password or strlen($password) < 8) {
                $this->addFlash('error', 'Verfier votre donnée');
                return $this->redirectToRoute('recruteur_new');
            }

            $user->setNom($nom);
            $user->setPrenom($prenom);
            $user->setEmail($email);
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $password
                )
            );
            $user->setRoles(['ROLE_RECRUTEUR']);
            $user->setDateOfAjout(new \DateTime('now'));
            $recruteur->setCin($cin);
            $recruteur->setTelephone($tel);
            $recruteur->setSexe($sexe);
            $recruteur->setResponsabilite($responsabilitee);
            $user->setRecruteur($recruteur);
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('success', 'Ajouter avec succée');
            return $this->redirectToRoute('recruteur_new');
        }

        return $this->render('admin/newRecruteur.html.twig');
    }


    /**
     * @Route("/admin/deleterecruteur/{id}", name="recruter_delete")
     */
    public function deleterecruteur(int $id): Response
    {
        $recruteur = $this->getDoctrine()->getManager()->getRepository(User::class)->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($recruteur);
        $entityManager->flush();
        $this->addFlash('suprimée', 'Candidat supprimée avec succée');
        return $this->redirectToRoute('recruteur_index');
    }

    /**
     * @Route("/admin/showrecruteur/{id}", name="recruteur_show")
     */
    public function showRecruteur(int $id, HttpFoundationRequest $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = $this->getDoctrine()->getManager()->getRepository(User::class)->find($id);
        dump($user);

        $cin = $request->get('cin');
        $nom = $request->get('nom');
        $prenom = $request->get('prenom');
        $email = $request->get('email');
        $password = $request->get('password');
        $responsabilitee = $request->get('responsabilitee');
        $sexe = $request->get('sexe');
        $tel = $request->get('telephone');
        $recruteur = $user->getRecruteur();
        if ($request->getMethod() == "POST") {
            $user->setNom($nom);
            $user->setPrenom($prenom);
            $user->setEmail($email);
            if ($password != null) {
                if (strlen($password) < 8) {
                    $this->addFlash('error', 'Verfier votre donnée');
                    return $this->redirectToRoute('recruteur_show', ['id' => $id]);
                }
                $user->setPassword(
                    $passwordEncoder->encodePassword(
                        $user,
                        $password
                    )
                );
            }
            $recruteur->setCin($cin);
            $recruteur->setTelephone($tel);
            $recruteur->setSexe($sexe);
            $recruteur->setResponsabilite($responsabilitee);
            $user->setRecruteur($recruteur);
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Modifier avec succée');
            return $this->redirectToRoute('recruteur_show', ['id' => $id]);
        }

        return $this->render('admin/showRecruteur.html.twig', ['recruteur' => $user]);
    }

    /**
     * @Route("/all/candidats", name="candidats")
     */
    public function candidats(): Response
    {
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();
        $candidats = [];
        foreach ($users as $user) {
            if ($user->getRoles()[0] == 'ROLE_CANDIDAT') {
                array_push($candidats, $user);
            }
        }

        return $this->render('recruteur/candidats.html.twig', [
            'candidats' => $candidats,
        ]);
    }

    /**
     * @Route("/recruteur/candidateur/{id}", name="canditeur_candidat")
     */
    public function candidateur(int $id, HttpFoundationRequest $request): Response
    {
        $offre = $this->getDoctrine()->getManager()->getRepository(OffreDemploi::class)->find($id);
        $candidat = $this->getDoctrine()->getManager()->getRepository(Candidatures::class)->findByOffre($offre);

        if ($request->getMethod() == "POST") {

            $date = $request->get('date');
            $cand = $request->get('name');

            dump((int)$cand);
            $entityManager = $this->getDoctrine()->getManager();
            $candidateur = $this->getDoctrine()->getRepository(Candidatures::class)->find((int)$cand);
            dump($candidateur);
            $offre = $candidateur->getOffre()->getId();


            $candidateur->setDaterdz(new DateTime($date));
            $candidateur->setValidation(true);
            $entityManager->flush();
            return $this->redirectToRoute('canditeur_candidat', ['id' => $offre]);
        }
        return $this->render('recruteur/candidateur.html.twig', [
            'conds' => $candidat,
        ]);
    }


    /**
     * @Route("/recruteur/refus/{id}", name="refus_postulation")
     */
    public function refus(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $candidateur = $this->getDoctrine()->getRepository(Candidatures::class)->find($id);
        $offre = $candidateur->getOffre()->getId();
        dump($id);
        $candidateur->setValidation(false);
        $candidateur->setDaterdz(null);
        $entityManager->flush();
        return $this->redirectToRoute('canditeur_candidat', ['id' => $offre]);
    }
}

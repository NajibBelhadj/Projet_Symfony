<?php

namespace App\Controller;

use App\Entity\Candidat;
use App\Entity\Recruteur;
use App\Entity\User;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;


/**
 * @Route("/admin")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/tableadmin", name="admin_index")
     */
    public function index(): Response
    {
        // get list of admins
        $liste = [];
        $admins = $this->getDoctrine()->getRepository(User::class)->findAll();
        foreach ($admins as $admin) {
            if ($admin->getRoles()[0] == "ROLE_ADMIN") {
                array_push($liste, $admin);
            }
        }
        return $this->render('admin/tableAdmin.html.twig', [
            'admins' => $liste
        ]);
    }
    /**
     * @Route("/admin/addcandidatnb/{id}", name="candidat_addnb", methods={"GET","POST"})
     */
    public function addcandidatnb(int $id, HttpFoundationRequest $request): Response
    {
        // admin to set nombres des candidatures pour l'utilisateur  
        $entityManager = $this->getDoctrine()->getManager();
        $user = $this->getDoctrine()->getManager()->getRepository(User::class)->find($id);
        $candidat = $user->getCandidat();
        $nb = $request->get('nb');
        dump($candidat);
        if ($nb <= 0) {
            $this->addFlash('error', 'Verifier le Numbre');
            return $this->redirectToRoute('candidat_index');
        }
        $candidat->setNbPostulationAutorisee((int)$nb);
        $entityManager->flush();
        $this->addFlash('suprimée', 'Ajout avec succée');
        return $this->redirectToRoute('candidat_index');
    }

    /**
     * @Route("/newAdmin", name="admin_new")
     */
    public function newAdmin(HttpFoundationRequest $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        // add new admin and check wether if email exist or valid password
        $entityManager = $this->getDoctrine()->getManager();
        $nom = $request->get('nom');
        $prenom = $request->get('prenom');
        $email = $request->get('email');
        $password = $request->get('password');
        $confirm_password = $request->get('confirm_password');
        dump($nom);

        $admin = new User();
        if ($request->getMethod() == "POST") {
            $admins = $this->getDoctrine()->getRepository(User::class)->findAll();
            foreach ($admins as $admin) {
                if ($admin->getEmail() == $email) {
                    $this->addFlash('error', 'Email already Exist');
                    return $this->redirectToRoute('admin_new');
                }
            }
            if ($password != $confirm_password or strlen($password) < 8) {
                $this->addFlash('error', 'Verfier votre donnée');
                return $this->redirectToRoute('admin_new');
            }
            $admin->setNom($nom);
            $admin->setPrenom($prenom);
            $admin->setEmail($email);
            $admin->setPassword(
                $passwordEncoder->encodePassword(
                    $admin,
                    $password
                )
            );
            $admin->setRoles(['ROLE_ADMIN']);
            $admin->setDateOfAjout(new \DateTime('now'));
            $entityManager->persist($admin);
            $entityManager->flush();
            $this->addFlash('success', 'Ajouter avec succée');
            return $this->redirectToRoute('admin_new');
        }

        return $this->render('admin/newAdmin.html.twig');
    }

    /**
     * @Route("/deleteAdmin/{id}", name="admin_delete")
     */
    public function deleteAdmin(int $id): Response
    {
        $admin = $this->getDoctrine()->getManager()->getRepository(User::class)->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($admin);
        $entityManager->flush();
        $this->addFlash('suprimée', 'Admin supprimée avec succée');
        return $this->redirectToRoute('admin_index');
    }
}

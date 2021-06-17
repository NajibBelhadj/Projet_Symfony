<?php

namespace App\Controller;

use App\Entity\Experience;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;

class ExperienceController extends AbstractController
{
    /**
     * @Route("/candidat/modifierexperience/{id}", name="edit_experience")
     */
    public function editexper(int $id, HttpFoundationRequest $request): Response
    {
        //edit exp
        $entityManager = $this->getDoctrine()->getManager();
        $experience = $entityManager->getRepository(Experience::class)->find($id);
        $post = $request->get('post');
        dump($experience);
        $date = $request->get('date');
        $decription = $request->get('description');
        if ($request->getMethod() == "POST") {
            $experience->setPost($post);
            $experience->setDescription($decription);
            $experience->setDate($date);
            $entityManager->flush();
            $this->addFlash('success', 'Modifier avec succée');
            return $this->redirectToRoute('edit_experience', ['id' => $id]);
        }
        return $this->render('candidat/editexper.html.twig', [
            'experience' => $experience,
        ]);
    }

    /**
     * @Route("/candidat/deleteexperience/{id}", name="delete_experience")
     */
    public function deliteexper(int $id): Response
    {
        //edit exp
        $entityManager = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $idu = $user->getId();
        $experience = $entityManager->getRepository(Experience::class)->find($id);
        $entityManager->remove($experience);
        $entityManager->flush();
        return $this->redirectToRoute('candidat_cv', ['id' => $idu]);
    }

    /**
     * @Route("/candidat/ajouterexperience", name="new_experience")
     */
    public function addexper(HttpFoundationRequest $request): Response
    {
        //add exp
        $entityManager = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $candidat = $user->getCandidat();
        $experience = new Experience();
        $post = $request->get('post');
        $date = $request->get('date');
        $decription = $request->get('description');
        if ($request->getMethod() == "POST") {
            $experience->setPost($post);
            $experience->setDescription($decription);
            $experience->setDate($date);
            $experience->setCandidat($candidat);
            $entityManager->persist($experience);
            $entityManager->flush();
            $this->addFlash('success', 'Ajouter avec succée');
            return $this->redirectToRoute('new_experience');
        }
        return $this->render('candidat/addexper.html.twig', [
            'experience' => $experience,
        ]);
    }
}

<?php

namespace App\Controller;

use App\Entity\Categorie;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;

class CategoryController extends AbstractController
{
    /**
     * @Route("recruteur/categorie/all", name="category")
     */
    public function index(): Response
    {
        $recruteur = $this->getUser()->getRecruteur();
        $categories = $this->getDoctrine()->getRepository(Categorie::class)->findByRecruteur($recruteur);
        dump($categories);
        return $this->render('recruteur/categorie.html.twig', [
            'categorie' => $categories,
        ]);
    }

    /**
     * @Route("recruteur/categorie/new", name="category_new")
     */
    public function ajouter(HttpFoundationRequest $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $categorie = $request->get('categorie');
        $recruteur = $this->getUser()->getRecruteur();
        $categories = new Categorie();
        if ($request->getMethod() == "POST") {
            $categories->setName($categorie);
            $categories->setRecruteur($recruteur);
            $entityManager->persist($categories);
            $entityManager->flush();
            $this->addFlash('success', 'Ajouter avec succée');
            return $this->redirectToRoute('category_new');
        }

        return $this->render('recruteur/newCategorie.html.twig', []);
    }

    /**
     * @Route("recruteur/categorie/edit/{id}", name="category_edit")
     */
    public function edit(HttpFoundationRequest $request, int $id): Response
    {
        $categorie = $this->getDoctrine()->getManager()->getRepository(Categorie::class)->find($id);
        $nom = $request->get('categorie');
        $description = $request->get('description');
        if ($request->getMethod() == "POST") {
            $categorie->setName($nom);
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Modifier avec succée');
            return $this->redirectToRoute('category_edit', ['id' => $id]);
        }
        return $this->render('recruteur/editCategorie.html.twig', [
            'categorie' => $categorie
        ]);
    }

    /**
     * @Route("recruteur/categorie/delete/{id}", name="category_edit")
     */
    public function delete(int $id): Response
    {
        $categorie = $this->getDoctrine()->getManager()->getRepository(Categorie::class)->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($categorie);
        $entityManager->flush();
        $this->addFlash('suprimée', 'Offre supprimée avec succée');
        return $this->redirectToRoute('category');

        return $this->render('recruteur/editCategorie.html.twig', [
            'categorie' => $categorie
        ]);
    }
}

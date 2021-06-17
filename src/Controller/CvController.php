<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CvController extends AbstractController
{
    /**
     * @Route("/cv/{id}", name="candidat_cv")
     */
    public function cv(int $id): Response
    {
        //cv
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);

        return $this->render('candidat/cv.html.twig', [
            'user' => $user,
        ]);
    }
}

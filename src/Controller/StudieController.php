<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StudieController extends AbstractController
{
    /**
     * @Route("/studie", name="studie")
     */
    public function index(): Response
    {
        return $this->render('studie/index.html.twig', [
            'controller_name' => 'StudieController',
        ]);
    }
}

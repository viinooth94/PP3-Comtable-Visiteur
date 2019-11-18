<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class StartPageController extends AbstractController
{
    /**
     * @Route("/start/page", name="start_page")
     */
    public function index()
    {
        return $this->render('StartPage.html.twig', [
            'controller_name' => 'StartPageController',
        ]);
    }
}

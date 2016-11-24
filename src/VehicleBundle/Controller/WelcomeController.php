<?php

namespace VehicleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use VehicleBundle\Entity\User;

class WelcomeController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        $user = $this->getUser();
        return $this->render('VehicleBundle:Welcome:index.html.twig', ['user' => $user]);
    }
}

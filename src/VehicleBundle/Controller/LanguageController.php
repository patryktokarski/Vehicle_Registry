<?php

namespace VehicleBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class LanguageController extends Controller
{
    /**
     * @Route("/settings", name = "settings")
     * @Template()
     */

    public function settingsAction(Request $request) {

        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('settings'))
            ->setMethod("POST")
            ->add("Language", 'choice', array(
                'choices' => array(
                    'pl' => 'Polish',
                    'en' => 'English',
                    'de' => 'German',
                )
            ))
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($request->get('form')['Language'] == 'pl') {
                $this->get('session')->set('_locale', 'pl');
                return $this->redirect($request->headers->get('referer'));
            } elseif ($request->get('form')['Language'] == 'en') {
                $this->get('session')->set('_locale', 'en');
                return $this->redirect($request->headers->get('referer'));
            } else {
                $this->get('session')->set('_locale', 'de');
                return $this->redirect($request->headers->get('referer'));
            }
        }
//
        return ['form' => $form->createView()];
    }
}

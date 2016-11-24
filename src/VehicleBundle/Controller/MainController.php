<?php

namespace VehicleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use VehicleBundle\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use JsonSerializable;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use VehicleBundle\Entity\Model;

class MainController extends Controller
{
    /**
     * @Route("/", name = "main")
     * @Template()
     */
    
    public function mainAction() {
        
        $user = $this->getUser();

        
        $form = $this->createFormBuilder()
                ->setAction($this->generateUrl('show_vehicles'))
                ->setMethod('POST')
                ->add('Brand', 'entity', array(
                    'class' => 'VehicleBundle:Brand',
                    'choice_label' => 'name',))
                ->add('Model', 'entity', array(
                    'class' => 'VehicleBundle:Model',
                    'choice_label' => 'name',))
                ->add('save', 'submit', array('label' => 'Search'))
                ->getForm();



        return $this->render('VehicleBundle:Main:main.html.twig', [
            'user' => $user,
            'form' => $form->createView()]);
        
    }  
    
    /**
     * @Route("/jsonmodels")
     * @param Request $request
     * @return type
     * @Template()
     */
    
    
    public function updateFormAction (Request $request) {
        
        $user = $this->getUser();
        
        $brandId = $request->request->get("brandId");
        
        $em = $this->getDoctrine()->getManager();
        $brand = $em->getRepository("VehicleBundle:Brand")->findById($brandId);
        
        $em = $this->getDoctrine()->getManager();
        $models = $em->getRepository("VehicleBundle:Model")->findByBrand($brand);
        echo json_encode($models);
        
        $response = new JsonResponse();
        $response->setData(array('models' => $models));
        return ['models' => $models];
    }
    
    
    /**
     * @Route("/showVehicles", name = "show_vehicles")
     * @Method("POST")
     * @Template()
     */
    
    public function showVehiclesAction (Request $request) {
        
        $em = $this->getDoctrine()->getManager();
        
        $brandId = $request->get('form')['Brand'];     
        $modelId = $request->get('form')['Model'];
        
        $brand = $em->getRepository("VehicleBundle:Brand")->findById($brandId);
        $model = $em->getRepository("VehicleBundle:Model")->findById($modelId);
        
        if (!isset($modelId) || empty($model)) {
            $cars = $em->getRepository("VehicleBundle:Car")->findByBrand($brand);
            return ["cars" => $cars, 'brand' => $brand, 'model' => $model];
        } else {
            $cars = $em->getRepository("VehicleBundle:Car")->findByModel($model);
            return ["cars" => $cars, 'brand' => $brand, 'model' => $model];
        }
        
        return [];

    }

}

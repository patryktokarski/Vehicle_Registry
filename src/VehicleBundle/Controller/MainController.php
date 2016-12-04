<?php

namespace VehicleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;


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
        $cars = $em->getRepository("VehicleBundle:Car")->findByModel($model);

        $carsTotalAvg = [];
        $allRepairCategoryIds = [];

        foreach ($cars as $car) {
            $refuels = $em->getRepository("VehicleBundle:Refuel")->findByCar($car);
            $repairs = $em->getRepository("VehicleBundle:Repair")->findByCar($car);

            foreach ($repairs as $repair) {
                $category = $repair->getCategory();
                $categoryId = $category->getId();
                $allRepairCategoryIds[] = $categoryId;
            }
            $allRepairs = count($allRepairCategoryIds);
            $totalFuel = 0;
            $i = 0;
            foreach ($refuels as $refuel) {
                $avgFuel = $refuel->getAvgFuelConsumption();
                $totalFuel += $avgFuel;
                $i++;
            }
            if ($i != 0) {
                $totalAvg = $totalFuel/$i;
                $carsTotalAvg[] = $totalAvg;
            } else {
                $carsTotalAvg[] = 0;
            }
        }

        $percentage = [];
        if ($allRepairCategoryIds != []) {
            $counts = array_count_values($allRepairCategoryIds);
            $mostRepeatedCategories = array_slice($counts, 0, 2, true);
            $tops = array_keys($mostRepeatedCategories);
            $topCategories = [];
            foreach ($tops as $top) {
                $category = $em->getRepository("VehicleBundle:Category")->findById($top);
                $topCategories[] = $category;
                $percentage[] = ($counts[$top]/$allRepairs)*100;
            }

        } else {
            $topCategories = [];

        }
        return ["cars" => $cars,
            'brand' => $brand,
            'model' => $model,
            'carsTotalAvg' => $carsTotalAvg,
            'topCategories' => $topCategories,
            'percentage' => $percentage,
            'allRepairs' => $allRepairs
        ];
    }
}

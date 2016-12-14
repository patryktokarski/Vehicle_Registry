<?php

namespace VehicleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;


class MainController extends Controller
{
    /**
     * @Route("/", name = "main")
     * @Template()
     */

    public function mainAction(Request $request) {

        $form = $this->get('form.factory')->createNamedBuilder('', 'form', array(
                'csrf_protection' => false,
            ))
                ->setAction($this->generateUrl('show_vehicles', array(
                    'brand' => $request->query->get('brand'),
                    'model' => $request->query->get('model')
            )))
                ->setMethod('GET')
                ->add('brand', 'entity', array(
                    'class' => 'VehicleBundle:Brand',
                    'choice_label' => 'name',
                    'translation_domain' => 'messages'))
                ->add('model', 'entity', array(
                    'class' => 'VehicleBundle:Model',
                    'choice_label' => 'name',
                    'translation_domain' => 'messages'))
                ->getForm();

        return $this->render('VehicleBundle:Main:main.html.twig', [
            'form' => $form->createView()]);
    }  
    
    /**
     * @Route("/jsonmodels")
     * @param Request $request
     * @return type
     * @Template()
     */

    public function updateFormAction (Request $request) {

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
     * @Template()
     */
    
    public function showVehiclesAction (Request $request, $page) {

        $em = $this->getDoctrine()->getManager();
        $brandId = $request->query->get('brand');
        $modelId = $request->query->get('model');
        $brand = $em->getRepository("VehicleBundle:Brand")->findById($brandId);
        $model = $em->getRepository("VehicleBundle:Model")->findById($modelId);
        $cars = $em->getRepository("VehicleBundle:Car")->findBy(array('brand' => $brand, 'model' => $model));
        $carsNum = count($cars);
        /**
         * @var $paginator \KNP\Component\Pager\Paginator
         */
        $paginator = $this->get('knp_paginator');
        $result = $paginator->paginate(
            $cars,
            $request->query->getInt('page', $page),
            $request->query->getInt('limit', 3)
        );

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
                $car->setAvgFuelConsumption($totalAvg);
            } else {
                $carsTotalAvg[] = 0;
            }
        }

        $number = [];
        if ($allRepairCategoryIds != []) {
            $counts = array_count_values($allRepairCategoryIds);
            $mostRepeatedCategories = array_slice($counts, 0, 2, true);
            $tops = array_keys($mostRepeatedCategories);
            $topCategories = [];
            foreach ($tops as $top) {
                $category = $em->getRepository("VehicleBundle:Category")->findById($top);
                $topCategories[] = $category;
                $number[] = $counts[$top];
            }

        } else {
            $topCategories = [];
            $allRepairs = 0;
        }
        return [
            'cars' => $result,
            'brand' => $brand,
            'model' => $model,
            'carsTotalAvg' => $carsTotalAvg,
            'topCategories' => $topCategories,
            'number' => $number,
            'allRepairs' => $allRepairs,
            'carsNum' => $carsNum
        ];
    }
}

<?php

namespace VehicleBundle\Controller;

use VehicleBundle\Entity\Car;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use VehicleBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Car controller.
 *
 * @Route("car")
 */
class CarController extends Controller
{
    /**
     * Lists all car entities.
     *
     * @Route("/", name="car_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $cars = $em->getRepository('VehicleBundle:Car')->findByUser($user);

        return $this->render('car/index.html.twig', array(
            'cars' => $cars,
        ));
    }

    /**
     * Creates a new car entity.
     *
     * @Route("/new", name="car_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $car = new Car();
        $form = $this->createForm('VehicleBundle\Form\CarType', $car);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $user = $this->getUser();
            $car->setUser($user);
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($car);
            $em->flush($car);

            return $this->redirectToRoute('car_index', array('id' => $user->getId()));
        }

        return $this->render('car/new.html.twig', array(
            'car' => $car,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a car entity.
     *
     * @Route("/{id}", name="car_show")
     * @Method("GET")
     */
    public function showAction(Car $car)
    {
        $deleteForm = $this->createDeleteForm($car);

        return $this->render('car/show.html.twig', array(
            'car' => $car,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing car entity.
     *
     * @Route("/{id}/edit", name="car_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Car $car)
    {
        $deleteForm = $this->createDeleteForm($car);
        $editForm = $this->createForm('VehicleBundle\Form\CarType', $car);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('car_edit', array('id' => $car->getId()));
        }

        return $this->render('car/edit.html.twig', array(
            'car' => $car,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a car entity.
     *
     * @Route("/{id}", name="car_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Car $car)
    {
        $form = $this->createDeleteForm($car);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($car);
            $em->flush($car);
        }

        return $this->redirectToRoute('car_index');
    }

    /**
     * Creates a form to delete a car entity.
     *
     * @param Car $car The car entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Car $car)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('car_delete', array('id' => $car->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    
    /**
     * @Route("showVehicleRepo/{id}", name = "show_vehicle_repo")
     * @Method("GET")
     * @Template()
     * @param type $id
     * @return array
     */
    
    
    public function showVehicleRepoAction ($id) {
        $user = $this->getUser();
        
        $em = $this->getDoctrine()->getManager();
        $car = $em->getRepository("VehicleBundle:Car")->findById($id);
        $refuels = $em->getRepository("VehicleBundle:Refuel")->findByCar($car);
        $repairs = $em->getRepository("VehicleBundle:Repair")->findByCar($car);

        $totalAvg = 0;
        $i = 0;
        foreach ($refuels as $refuel) {
            $singleConsumption = $refuel->getAvgFuelConsumption();
            $totalAvg += $singleConsumption;
            $i++;
        }
        if ($i != 0) {
            $total = $totalAvg/$i;
        } else {
            $total = 0;
        }
        
        return ['user' => $user, 'car' => $car, 'refuels' => $refuels, 'repairs' => $repairs, 'total' => $total];
    }
    
    
    /**
     * @Route("/showVehicleInfo/{id}", name = "show_vehicle_info")
     * @Template()
     * @Method("GET")
     */
    
    public function showVehicleInfoAction($id) {
        $user = $this->getUser();
        
        $em = $this->getDoctrine()->getManager();
        $car = $em->getRepository("VehicleBundle:Car")->findById($id);
        $refuels = $em->getRepository("VehicleBundle:Refuel")->findByCar($car);
        $repairs = $em->getRepository("VehicleBundle:Repair")->findByCar($car);

        $totalAvg = 0;
        $i = 0;
        foreach ($refuels as $refuel) {
            $singleConsumption = $refuel->getAvgFuelConsumption();
            $totalAvg += $singleConsumption;
            $i++;
        }
        if ($i != 0) {
            $total = $totalAvg/$i;
        } else {
            $total = 0;
        }
        return ['user' => $user, 'car' => $car, 'refuels' => $refuels, 'repairs' => $repairs, 'total' => $total];
    }
}

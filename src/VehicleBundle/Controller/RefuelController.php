<?php

namespace VehicleBundle\Controller;

use Symfony\Component\Form\Test\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\GreaterThan;
use VehicleBundle\Entity\Refuel;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bridge\Doctrine\Tests\Validator\Constraints as Assert;
use VehicleBundle\Validator\Constraints\StartGreaterThanDefault;


/**
 * Refuel controller.
 *
 * @Route("refuel")
 */
class RefuelController extends Controller
{
    /**
     * Lists all refuel entities.
     *
     * @Route("/", name="refuel_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $refuels = $em->getRepository('VehicleBundle:Refuel')->findAll();

        return $this->render('refuel/index.html.twig', array(
            'refuels' => $refuels,
        ));
    }

    /**
     * Creates a new refuel entity.
     *
     * @Route("/new/{id}", name="refuel_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $car = $em->getRepository("VehicleBundle:Car")->findById($id);
        $refuels = $em->getRepository("VehicleBundle:Refuel")->findByCar($car);
        if ($refuels == []) {
            $lastEndKm = 0;
        } else {
            $lastRefuel = $refuels[count($refuels)-1];
            $lastEndKm = $lastRefuel->getKilometerEnd();
        }

        $refuel = new Refuel();
        $form = $this->createFormBuilder($refuel)
            ->add('date')
            ->add('liters', 'integer', ['required' => false])
            ->add('kilometerStart', 'integer', array(
                  'required' => false,
                  'data' => $lastEndKm,
                  'constraints' => new StartGreaterThanDefault($lastEndKm)))
                  //'constraints' => new GreaterThan($lastEndKm)))
            ->add('kilometerEnd', 'integer', ['required' => false])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            $car = $em->getRepository("VehicleBundle:Car")->findById($id);
            $refuel->setCar($car[0]);
            $start = $refuel->getKilometerStart();
            $end = $refuel->getKilometerEnd();
            $liters = $refuel->getLiters();
            $avg = ($liters/($end - $start))*100;
            $refuel->setAvgFuelConsumption($avg);
            $car = $refuel->getCar();
            $id = $car->getId();

            $em->persist($refuel);
            $em->flush($refuel);

            $this->get('session')->getFlashBag()->add('notice', 'Refuel added to registry');
            return $this->redirectToRoute('show_vehicle_repo', [
                'avg' => $avg,
                'id' => $id
            ]);
        }

        return $this->render('refuel/new.html.twig', [
            'refuel' => $refuel,
            'form' => $form->createView(),
            'id' => $id,
        ]);
    }

    /**
     * Finds and displays a refuel entity.
     *
     * @Route("/{id}", name="refuel_show")
     * @Method("GET")
     */
    public function showAction(Refuel $refuel)
    {
        $deleteForm = $this->createDeleteForm($refuel);

        return $this->render('refuel/show.html.twig', array(
            'refuel' => $refuel,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing refuel entity.
     *
     * @Route("/{id}/edit", name="refuel_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Refuel $refuel)
    {
        $deleteForm = $this->createDeleteForm($refuel);
        $editForm = $this->createForm('VehicleBundle\Form\RefuelType', $refuel);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('refuel_edit', array('id' => $refuel->getId()));
        }

        return $this->render('refuel/edit.html.twig', array(
            'refuel' => $refuel,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a refuel entity.
     *
     * @Route("/{id}", name="refuel_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Refuel $refuel)
    {
        $form = $this->createDeleteForm($refuel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($refuel);
            $em->flush($refuel);
        }
        $car = $refuel->getCar();
        $id = $car->getId();

        return $this->redirectToRoute('show_vehicle_repo', ['id' => $id]);
    }

    /**
     * Creates a form to delete a refuel entity.
     *
     * @param Refuel $refuel The refuel entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Refuel $refuel)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('refuel_delete', array('id' => $refuel->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

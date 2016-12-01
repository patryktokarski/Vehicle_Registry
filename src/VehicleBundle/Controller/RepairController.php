<?php

namespace VehicleBundle\Controller;

use VehicleBundle\Entity\Repair;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Repair controller.
 *
 * @Route("repair")
 */
class RepairController extends Controller
{
    /**
     * Lists all repair entities.
     *
     * @Route("/", name="repair_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $repairs = $em->getRepository('VehicleBundle:Repair')->findAll();

        return $this->render('repair/index.html.twig', array(
            'repairs' => $repairs,
        ));
    }

    /**
     * Creates a new repair entity.
     *
     * @Route("/new/{id}", name="repair_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, $id)
    {
        $repair = new Repair();
        $form = $this->createForm('VehicleBundle\Form\RepairType', $repair);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            $car = $em->getRepository("VehicleBundle:Car")->findById($id);
            $repair->setCar($car[0]);
            
            $em->persist($repair);
            $em->flush($repair);

            return $this->redirectToRoute('repair_show', array('id' => $repair->getId()));
        }

        return $this->render('repair/new.html.twig', array(
            'repair' => $repair,
            'form' => $form->createView(),
            'id' => $id,
        ));
    }

    /**
     * Finds and displays a repair entity.
     *
     * @Route("/{id}", name="repair_show")
     * @Method("GET")
     */
    public function showAction(Repair $repair)
    {
        $deleteForm = $this->createDeleteForm($repair);

        return $this->render('repair/show.html.twig', array(
            'repair' => $repair,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing repair entity.
     *
     * @Route("/{id}/edit", name="repair_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Repair $repair)
    {
        $deleteForm = $this->createDeleteForm($repair);
        $editForm = $this->createForm('VehicleBundle\Form\RepairType', $repair);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('repair_edit', array('id' => $repair->getId()));
        }

        return $this->render('repair/edit.html.twig', array(
            'repair' => $repair,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a repair entity.
     *
     * @Route("/{id}", name="repair_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Repair $repair)
    {
        $form = $this->createDeleteForm($repair);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($repair);
            $em->flush($repair);
        }

        return $this->redirectToRoute('repair_index');
    }

    /**
     * Creates a form to delete a repair entity.
     *
     * @param Repair $repair The repair entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Repair $repair)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('repair_delete', array('id' => $repair->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    
    /**
     * @Route("/showRepairInfo/{id}", name = "show_repair_info")
     * @Template()
     */
    
    public function showRepairInfoAction($id) {
        $em = $this->getDoctrine()->getManager();
        $repair = $em->getRepository("VehicleBundle:Repair")->findById($id);
        
        return ['repair' => $repair];
    }
}
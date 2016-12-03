<?php

namespace VehicleBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Doctrine\ORM\EntityManager;

class StartGreaterThanDefaultValidator extends ConstraintValidator {

    protected $em;

    public function __construct(EntityManager $em) {

        $this->em = $em;
    }
    public function  validate($value, Constraint $constraint) {

//        $newValue = $value;
//        $car = $constraint->getCar();
//
//        $refuels = $this->em->getRepository("VehicleBundle:Refuel")->findByCar($car);
//        $lastRefuel = $refuels[count($refuels) - 1];
//        $lastEndKm = $lastRefuel->getKilometerEnd();
//
//        if ($newValue < $lastEndKm) {
//
//            $this->context->buildViolation($constraint->message)
//                ->setParameter("%value%", $lastEndKm)
//                ->addViolation();
//        }
    }


    }

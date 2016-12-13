<?php

namespace VehicleBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class StartGreaterThanDefaultValidator extends ConstraintValidator {

    public function  validate($value, Constraint $constraint) {

        $newValue = $value;
        $lastEndKm = $constraint->getLastEndKm();
        if ($newValue < $lastEndKm) {

            $this->context->buildViolation($constraint->message)
                ->setParameter("%value%", $lastEndKm)
                ->addViolation();
        }
    }
}

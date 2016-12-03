<?php

namespace VehicleBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 * @Target({"PROPERTY", "METHOD", "ANNOTATION"})
 */

class StartGreaterThanDefault extends Constraint {

    public $message = 'The Kilometer start value cannot be lower than previous kilometer end (%value%).';
    public $car;

    public function __construct($options) {

        $this->car = $options;

    }

    public function getCar() {
        return $this->car;
    }

}
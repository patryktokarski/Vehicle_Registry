<?php

namespace VehicleBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 * @Target({"PROPERTY", "METHOD", "ANNOTATION"})
 */

class StartGreaterThanDefault extends Constraint {

    public $message = 'The Kilometer start value cannot be lower than previous kilometer end (%value%).';
    public $lastEndKm;

    public function __construct($options) {

        $this->lastEndKm = $options;
    }

    public function getLastEndKm() {
        return $this->lastEndKm;
    }

    public function getDefaultOption() {

        return 'lastEndKm';
    }

}

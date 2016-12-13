<?php

namespace VehicleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use VehicleBundle\Validator\Constraints as AcmeAssert;

/**
 * Refuel
 *
 * @ORM\Table(name="refuel")
 * @ORM\Entity(repositoryClass="VehicleBundle\Repository\RefuelRepository")
 */
class Refuel
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @var float
     *
     * @ORM\Column(name="liters", type="float")
     * @Assert\NotBlank(
     *     message = "This value cannot be empty"
     * )
     * @Assert\GreaterThan(
     *     0,
     *     message = "This value must be greater than 0"
     * )
     */
    private $liters;

    /**
     * @var int
     *
     * @ORM\Column(name="kilometer_start", type="integer")
     * @Assert\NotBlank(
     *     message = "This value cannot be empty"
     * )
     */
    private $kilometerStart;

    /**
     * @var int
     *
     * @ORM\Column(name="kilometer_end", type="integer", nullable=true)
     * @Assert\NotBlank(
     *     message = "This value cannot be empty"
     * )
     */
    private $kilometerEnd;

    /**
     * @Assert\True(message = "Kilometer end must be greater than kilometer start")
     */

    public function isEndBiggerThanStart() {
        if ($this->getKilometerEnd() != null) {
            return($this->getKilometerEnd() > $this->getKilometerStart());
        }
        return null;
    }

    /**
     * @var float
     *
     * @ORM\Column(name="avg_fuel_consumption", type="float")
     */
    private $avgFuelConsumption;


        /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set date
     *
     * @param \Date $date
     * @return Refuel
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \Date 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set liters
     *
     * @param float $liters
     * @return Refuel
     */
    public function setLiters($liters)
    {
        $this->liters = $liters;

        return $this;
    }

    /**
     * Get liters
     *
     * @return float 
     */
    public function getLiters()
    {
        return $this->liters;
    }

    /**
     * Set kilometerStart
     *
     * @param integer $kilometerStart
     * @return Refuel
     */
    public function setKilometerStart($kilometerStart)
    {
        $this->kilometerStart = $kilometerStart;

        return $this;
    }

    /**
     * Get kilometerStart
     *
     * @return integer 
     */
    public function getKilometerStart()
    {
        return $this->kilometerStart;
    }

    /**
     * Set kilometerEnd
     *
     * @param integer $kilometerEnd
     * @return Refuel
     */
    public function setKilometerEnd($kilometerEnd)
    {
        $this->kilometerEnd = $kilometerEnd;

        return $this;
    }

    /**
     * Get kilometerEnd
     *
     * @return integer 
     */
    public function getKilometerEnd()
    {
        return $this->kilometerEnd;
    }

    /**
     * @ORM\ManyToOne(targetEntity="Car", inversedBy="refuels")
     * @ORM\JoinColumn(name="car_id", referencedColumnName="id")
     */
    private $car;


    /**
     * Set car
     *
     * @param \VehicleBundle\Entity\Car $car
     * @return Refuel
     */
    public function setCar(\VehicleBundle\Entity\Car $car = null)
    {
        $this->car = $car;

        return $this;
    }

    /**
     * Get car
     *
     * @return \VehicleBundle\Entity\Car 
     */
    public function getCar()
    {
        return $this->car;
    }

    /**
     * Set avgFuelConsumption
     *
     * @param integer $avgFuelConsumption
     * @return Refuel
     */
    public function setAvgFuelConsumption($avgFuelConsumption)
    {
        $this->avgFuelConsumption = $avgFuelConsumption;

        return $this;
    }

    /**
     * Get avgFuelConsumption
     *
     * @return integer 
     */
    public function getAvgFuelConsumption()
    {
        return $this->avgFuelConsumption;
    }
}

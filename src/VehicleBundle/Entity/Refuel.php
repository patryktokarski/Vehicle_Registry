<?php

namespace VehicleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     */
    private $liters;

    /**
     * @var int
     *
     * @ORM\Column(name="kilometer_start", type="integer")
     */
    private $kilometerStart;

    /**
     * @var int
     *
     * @ORM\Column(name="kilometer_end", type="integer", nullable=true)
     */
    private $kilometerEnd;
    
    
    
    public function getAvgFuel(){
        return round(($this->liters/($this->kilometerEnd-$this->kilometerStart))*100,2);
    }

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
}

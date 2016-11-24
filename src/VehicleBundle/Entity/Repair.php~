<?php

namespace VehicleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Repair
 *
 * @ORM\Table(name="repair")
 * @ORM\Entity(repositoryClass="VehicleBundle\Repository\RepairRepository")
 */
class Repair
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
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var \Date
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @var float
     *
     * @ORM\Column(name="amount", type="float", nullable=true)
     */
    private $amount;


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
     * Set description
     *
     * @param string $description
     * @return Repair
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set date
     *
     * @param \Date $date
     * @return Repair
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
     * Set amount
     *
     * @param float $amount
     * @return Repair
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return float 
     */
    public function getAmount()
    {
        return $this->amount;
    }
    
    /**
    * @ORM\ManyToOne(targetEntity="Category", inversedBy="repairs")
    * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
    */
    private $category;
    
    /**
    * @ORM\ManyToOne(targetEntity="Car", inversedBy="repairs")
    * @ORM\JoinColumn(name="car_id", referencedColumnName="id")
    */
    private $car;


    /**
     * Set category
     *
     * @param \VehicleBundle\Entity\Category $category
     * @return Repair
     */
    public function setCategory(\VehicleBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \VehicleBundle\Entity\Category 
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set car
     *
     * @param \VehicleBundle\Entity\Car $car
     * @return Repair
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

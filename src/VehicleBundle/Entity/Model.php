<?php

namespace VehicleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Model
 *
 * @ORM\Table(name="model")
 * @ORM\Entity(repositoryClass="VehicleBundle\Repository\ModelRepository")
 */
class Model implements JsonSerializable
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
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     * @Assert\NotBlank(
     *     message = "Name cannot be empty"
     * )
     * @Assert\Regex(
     *     "/^[a-zA-Z0-9 \t]+$/",
     *     message = "Characters or numbers only"
     * )
     */
    private $name;


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
     * Set name
     *
     * @param string $name
     * @return Model
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * @ORM\ManyToOne(targetEntity="Brand", inversedBy="models")
     * @ORM\JoinColumn(name="model_id", referencedColumnName="id")
     */
    private $brand;

    /**
     * @ORM\OneToMany(targetEntity="Refuel", mappedBy="model")
     */
    
    private $cars;
    
    public function __construct() {
        $this->cars = new ArrayCollection();
    }
    
    
    /**
     * Set brand
     *
     * @param \VehicleBundle\Entity\Brand $brand
     * @return Model
     */
    public function setBrand(\VehicleBundle\Entity\Brand $brand = null)
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * Get brand
     *
     * @return \VehicleBundle\Entity\Brand
     * @Assert\NotBlank()
     */
    public function getBrand()
    {
        return $this->brand;
    }
    
    public function jsonSerialize() {
        return [
        'id'    =>$this->id,
        'name'  =>$this->name,
        'brand' =>$this->brand,
            ];
    }

    /**
     * Add cars
     *
     * @param \VehicleBundle\Entity\Refuel $cars
     * @return Model
     */
    public function addCar(\VehicleBundle\Entity\Refuel $cars)
    {
        $this->cars[] = $cars;

        return $this;
    }

    /**
     * Remove cars
     *
     * @param \VehicleBundle\Entity\Refuel $cars
     */
    public function removeCar(\VehicleBundle\Entity\Refuel $cars)
    {
        $this->cars->removeElement($cars);
    }

    /**
     * Get cars
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCars()
    {
        return $this->cars;
    }
    
    public function __toString() {
        return $this->name;
    }
}

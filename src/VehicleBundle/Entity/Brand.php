<?php

namespace VehicleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Brand
 *
 * @ORM\Table(name="brand")
 * @ORM\Entity(repositoryClass="VehicleBundle\Repository\BrandRepository")
 */
class Brand
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
     * @return Brand
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
     * @ORM\OneToMany(targetEntity="Model", mappedBy="brand")
     */
    private $models;

    public function __construct() {
        $this->models = new ArrayCollection();
    }


    /**
     * Add models
     *
     * @param \VehicleBundle\Entity\Model $models
     * @return Brand
     */
    public function addModel(\VehicleBundle\Entity\Model $models)
    {
        $this->models[] = $models;

        return $this;
    }

    /**
     * Remove models
     *
     * @param \VehicleBundle\Entity\Model $models
     */
    public function removeModel(\VehicleBundle\Entity\Model $models)
    {
        $this->models->removeElement($models);
    }

    /**
     * Get models
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getModels()
    {
        return $this->models;
    }
}
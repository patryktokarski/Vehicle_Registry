<?php

namespace VehicleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Category
 *
 * @ORM\Table(name="category")
 * @ORM\Entity(repositoryClass="VehicleBundle\Repository\CategoryRepository")
 */
class Category
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
     *@Assert\Regex(
     *     "/^[a-zA-Z0-9]+$/",
     *     message = "Required characters or numbers"
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
     * @return Category
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
    * @ORM\OneToMany(targetEntity="Repair", mappedBy="category")
    */
    private $repairs;

    public function __construct() {
        $this->repairs = new ArrayCollection();
    }


    /**
     * Add repairs
     *
     * @param \VehicleBundle\Entity\Repair $repairs
     * @return Category
     */
    public function addRepair(\VehicleBundle\Entity\Repair $repairs)
    {
        $this->repairs[] = $repairs;

        return $this;
    }

    /**
     * Remove repairs
     *
     * @param \VehicleBundle\Entity\Repair $repairs
     */
    public function removeRepair(\VehicleBundle\Entity\Repair $repairs)
    {
        $this->repairs->removeElement($repairs);
    }

    /**
     * Get repairs
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRepairs()
    {
        return $this->repairs;
    }
    
    public function __toString() {
        return $this->name;
    }
}

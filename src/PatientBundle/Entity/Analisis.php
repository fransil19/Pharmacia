<?php

namespace PatientBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Analisis
 *
 * @ORM\Table(name="analisis")
 * @ORM\Entity(repositoryClass="PatientBundle\Repository\AnalisisRepository")
 */
class Analisis
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

/**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Patient" , inversedBy="analisis")
     * @ORM\JoinTable(name="patient_analisis")
     */
    private $patients=null;

    public function __construct()
    {
        $this->patients = new ArrayCollection();
    }

    public function getPatients()
    {
        return $this->patients;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Analisis
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

    public function __toString(){
        return $this->name;
    }
}


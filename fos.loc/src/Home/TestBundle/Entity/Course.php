<?php

namespace Home\TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity(repositoryClass="Home\TestBundle\Repository\CourseRepository")
 * @ORM\Table(name="course")
 */
class Course
{

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $name;

    /**
     * @ORM\Column(type="text", length=65535)
     */
    protected $description;

    /**
     * @ORM\Column(type="float")
     */
    protected $price;

    /**
     * @ORM\ManyToMany(targetEntity="User", mappedBy="courses")
     **/
    protected $users;

    /**
     * @ORM\OneToMany(targetEntity="Cluster", mappedBy="course")
     */
    protected $clusters;

    public function __construct()
    {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
        $this->clusters = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @param mixed $users
     */
    public function setUsers(User $users)
    {
        $this->users = $users;
    }

    /**
     * @return mixed
     */
    public function getClusters()
    {
        return $this->clusters;
    }

    /**
     * @param mixed $groups
     */
    public function setClusters(Cluster $clusters)
    {
        $this->clusters = $clusters;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }


    function __toString()
    {
        return $this->getName();
    }






}

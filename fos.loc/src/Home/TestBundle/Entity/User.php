<?php
// src/Acme/UserBundle/Entity/User.php

namespace Home\TestBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Home\TestBundle\Repository\UserRepository")
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    const STUD = 'student';
    const COUCH = 'couch';

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     *
     * @ORM\Column(type="string", length=100)
     *
     * @Assert\NotBlank(message="Please enter your name.", groups={"Registration", "Profile"})
     * @Assert\Length(
     *     min=3,
     *     max="255",
     *     minMessage="The name is too short.",
     *     maxMessage="The name is too long.",
     *     groups={"Registration", "Profile"}
     * )
     */
    protected $name;

    /**
     * @ORM\Column(type="string", columnDefinition="ENUM('student', 'couch')")
     *
     * @Assert\NotBlank(message="Please chose a status.", groups={"Registration", "Profile"})
     *
     */
    protected $status;

    /**
     * @ORM\ManyToMany(targetEntity="Course", inversedBy="users")
     * @ORM\JoinTable(name="user_course")
     */
    protected $courses;

    /**
     * @ORM\ManyToMany(targetEntity="Cluster", inversedBy="users")
     * @ORM\JoinTable(name="user_group")
     */
    protected $clusters;

    /**
     * @ORM\OneToMany(targetEntity="Payment", mappedBy="user")
     */
    protected $payments;

    public function __construct()
    {
        parent::__construct();

        $this->groups = new \Doctrine\Common\Collections\ArrayCollection();
        $this->courses = new \Doctrine\Common\Collections\ArrayCollection();
        $this->payments = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getCourses()
    {
        return $this->courses;
    }

    /**
     * @param mixed $courses
     */
    public function setCourses($courses)
    {
        $this->courses = $courses;
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
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $role
     */
    public function setStatus($status)
    {
        if (!in_array($status, array(self::STUD, self::COUCH))) {
            throw new \InvalidArgumentException("Invalid status");
        }
        $this->status = $status;
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
    public function setClusters($clusters)
    {
        $this->clusters = $clusters;
    }

    /**
     * @return mixed
     */
    public function getPayments()
    {
        return $this->payments;
    }

    /**
     * @param mixed $payments
     */
    public function setPayments($payments)
    {
        $this->payments = $payments;
    }

    function __toString()
    {
        return $this->getEmail();
    }
}
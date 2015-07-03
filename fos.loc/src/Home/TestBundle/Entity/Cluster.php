<?php

namespace Home\TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Home\TestBundle\Repository\ClusterRepository")
 * @ORM\Table(name="cluster")
 */
class Cluster
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
    protected $room;

    /**
     * @ORM\ManyToMany(targetEntity="User", mappedBy="clusters")
     **/
    protected $users;

    /**
     * @ORM\ManyToOne(targetEntity="Course", inversedBy="clusters")
     * @ORM\JoinColumn(name="cluster_id", referencedColumnName="id")
     */
    protected $course;

    /**
     * @ORM\OneToMany(targetEntity="Payment", mappedBy="cluster")
     */
    protected $payments;

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

    public function __construct()
    {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
        $this->payments = new \Doctrine\Common\Collections\ArrayCollection();
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
    public function getRoom()
    {
        return $this->room;
    }

    /**
     * @param mixed $room
     */
    public function setRoom($room)
    {
        $this->room = $room;
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
    public function getCourse()
    {
        return $this->course;
    }

    /**
     * @param mixed $courses
     */
    public function setCourse($course)
    {
        $this->course = $course;
    }

    function __toString()
    {
        return $this->getRoom();
    }




}

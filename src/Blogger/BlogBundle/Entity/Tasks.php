<?php
// src/AppBundle/Entity/User.php

namespace Blogger\BlogBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Form\Extension\Core\Type\DateType;
/**
 * @ORM\Entity
 * @ORM\Table(name="tasks")
 * @ORM\HasLifecycleCallbacks()
 *
 */
class Tasks
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User", inversedBy="tasks")
     * @ORM\JoinColumn(name="id_my_user", referencedColumnName="id")
     */
    protected $user;


    /**
     * @var string
     * @ORM\Column(name="task", type="string", length=255)
     */
    protected $task;

    /**
     * @var boolean
     *
     * @ORM\Column(name="complete", type="boolean")
     */
    private $complete;

    /**
     * @var \DataTime
     * @ORM\Column(name="created", type="datetime")
     */
    protected $created;




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
     * Set task
     *
     * @param string $task
     *
     * @return Tasks
     */
    public function setTask($task)
    {
        $this->task = $task;

        return $this;
    }

    /**
     * Get task
     *
     * @return string
     */
    public function getTask()
    {
        return $this->task;
    }

    /**
     * Set complete
     *
     * @param boolean $complete
     *
     * @return Tasks
     */
    public function setComplete($complete)
    {
        $this->complete = $complete;

        return $this;
    }

    /**
     * Get complete
     *
     * @return boolean
     */
    public function getComplete()
    {
        return $this->complete;
    }

    /**
     * Set created
     * @ORM\PrePersist
     * @param \DateTime $created
     *
     * @return Tasks
     */
    public function setCreated($created)
    {
        if(!isset($this->created))
            $this->created = new \DateTime();

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set user
     *
     * @param \Blogger\BlogBundle\Entity\User $user
     *
     * @return Tasks
     */
    public function setUser(\Blogger\BlogBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Blogger\BlogBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}

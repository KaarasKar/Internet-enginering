<?php
// src/AppBundle/Entity/User.php

namespace Blogger\BlogBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * @ORM\Entity
 * @ORM\Table(name="my_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @ORM\OneToMany(targetEntity="Tasks", mappedBy="user")
     */
    protected $tasks;



    public function __construct()
    {
        parent::__construct();
        // your own logic
    }



    /**
     * Add task
     *
     * @param \Blogger\BlogBundle\Entity\Tasks $task
     *
     * @return User
     */
    public function addTask(\Blogger\BlogBundle\Entity\Tasks $task)
    {
        $this->tasks[] = $task;

        return $this;
    }

    /**
     * Remove task
     *
     * @param \Blogger\BlogBundle\Entity\Tasks $task
     */
    public function removeTask(\Blogger\BlogBundle\Entity\Tasks $task)
    {
        $this->tasks->removeElement($task);
    }

    /**
     * Get tasks
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTasks()
    {
        return $this->tasks;
    }
}

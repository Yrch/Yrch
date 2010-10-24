<?php

namespace Application\YrchBundle\Entity;

use Bundle\DoctrineUserBundle\Entity\User as BaseUser;

/**
 * Application\YrchBundle\Entity\User
 *
 * @Table(name="user")
 * @Entity
 */
class User extends BaseUser
{
    /**
     * @var integer $id
     *
     * @Column(name="id", type="integer")
     * @Id
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     *
     * @var string
     *
     * @Column(name="username", type="string(255)")
     */
    protected $username;

}
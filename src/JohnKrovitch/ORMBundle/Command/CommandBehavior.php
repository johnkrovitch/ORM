<?php

namespace JohnKrovitch\ORMBundle\Command;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\ORM\EntityManager;

trait CommandBehavior
{
    protected $entityManager;

    abstract function getContainer();

    /**
     * Return entityManager
     *
     * @param string $em
     * @return EntityManager
     */
    protected function getEntityManager($em = null)
    {
        if (!$this->entityManager) {
            $this->entityManager = $this->getDoctrine()->getManager($em);
        }
        return $this->entityManager;
    }

    /**
     * Return Doctrine
     *
     * @return Registry
     */
    protected function getDoctrine()
    {
        return $this->getContainer()->get('doctrine');
    }
} 
<?php

namespace AppBundle\Traits;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Metadata add extra data to entities
 *
 * @ORM\MappedSuperclass
 */
trait Visits
{

    /**
     * @var string
     *
     * @ORM\Column(name="visits", type="integer")
     */
    private $visits = 0;


    /**
     * Set name
     *
     * @param integer $visits
     *
     * @return $this
     */
    public function setVisits($visits)
    {
        $this->visits = $visits;

        return $this;
    }

    /**
     * Get name
     *
     * @return integer
     */
    public function getVisits()
    {
        return $this->visits;
    }

    
}
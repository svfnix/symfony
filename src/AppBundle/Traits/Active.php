<?php

namespace AppBundle\Traits;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Metadata add extra data to entities
 *
 * @ORM\MappedSuperclass
 */
trait Active
{

    /**
     * @var bool
     *
     * @ORM\Column(name="is_active", type="boolean", options={"default" = true})
     */
    private $isActive = true;

    /**
     * Set active
     *
     * @param boolean $isActive
     *
     * @return Cat
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get active
     *
     * @return bool
     */
    public function getIsActive()
    {
        return $this->isActive;
    }


}
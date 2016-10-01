<?php

namespace AppBundle\Traits;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Metadata add extra data to entities
 *
 * @ORM\MappedSuperclass
 */
trait Metadata
{
    /**
     * @var String
     *
     * @ORM\Column(name="meta_memo", type="string", length=255, nullable=true)
     */
    private $memo;

    /**
     * Set memo
     *
     * @param \Datetime $memo
     *
     * @return Object
     */
    public function setMemo($memo)
    {
        $this->memo = $memo;

        return $this;
    }

    /**
     * Get memo
     *
     * @return String
     */
    public function getMemo()
    {
        return $this->memo;
    }


}
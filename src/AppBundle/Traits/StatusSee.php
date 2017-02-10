<?php
/**
 * Created by PhpStorm.
 * User: svf
 * Date: 2/10/17
 * Time: 3:33 PM
 */

namespace AppBundle\Traits;


use AppBundle\Helper\Dictionary;

trait StatusSee
{
    /**
     * @var string
     *
     * @ORM\Column(name="status_see", type="string", length=32)
     */
    private $statusSee;

    /**
     * @return string
     */
    public function getStatusSee()
    {
        return $this->statusSee;
    }

    /**
     * @return $this
     */
    public function setStatusSeeSeen()
    {
        $this->statusSee = Dictionary::STATUS_SEE_SEEN;

        return $this;
    }

    /**
     * @return $this
     */
    public function setStatusSeeUnseen()
    {
        $this->statusSee = Dictionary::STATUS_SEE_UNSEEN;

        return $this;
    }
}
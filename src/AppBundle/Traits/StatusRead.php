<?php
/**
 * Created by PhpStorm.
 * User: svf
 * Date: 2/10/17
 * Time: 3:33 PM
 */

namespace AppBundle\Traits;


use AppBundle\Helper\Dictionary;

trait StatusRead
{
    /**
     * @var string
     *
     * @ORM\Column(name="status_read", type="string", length=32)
     */
    private $statusRead;

    /**
     * @return string
     */
    public function getStatusRead()
    {
        return $this->statusRead;
    }

    /**
     * @return $this
     */
    public function setStatusReadRead()
    {
        $this->statusRead = Dictionary::STATUS_READ_READ;

        return $this;
    }

    /**
     * @return $this
     */
    public function setStatusReadUnread()
    {
        $this->statusRead = Dictionary::STATUS_READ_UNREAD;

        return $this;
    }
}
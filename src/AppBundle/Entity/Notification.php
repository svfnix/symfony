<?php

namespace AppBundle\Entity;

use AppBundle\Traits\Base;
use AppBundle\Traits\StatusSee;
use AppBundle\Traits\Timestampable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Notification
 *
 * @ORM\Table(name="notification")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\NotificationRepository")
 */
class Notification
{
    use Base,
        Timestampable,
        StatusSee;

    const STATUS_SEEN = 'seen';
    const STATUS_UNSEEN = 'unseen';

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="text", length=512)
     * @Assert\NotNull(message="متن اطلاعیه را مشخص نمایید")
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="notification", type="text", length=16)
     */
    private $notification;


    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", cascade={"persist"})
     * @ORM\JoinColumn(name="receiver", referencedColumnName="id")
     * @Assert\NotNull(message="دریافت کننده اطلاعیه را مشخص نمایید")
     */
    private $receiver;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=32)
     */
    private $status = 'unseen';

    /**
     * Notification constructor.
     */
    function __construct()
    {
        $this->setCreatedAt();
        $this->setStatusSeeUnseen();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return Notification
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getNotification()
    {
        return $this->notification;
    }

    /**
     * @param string $notification
     * @return Notification
     */
    public function setNotification($notification)
    {
        $this->notification = $notification;
        return $this;
    }

    /**
     * @return User
     */
    public function getReceiver()
    {
        return $this->receiver;
    }

    /**
     * @param mixed $receiver
     * @return Notification
     */
    public function setReceiver(User $receiver)
    {
        $this->receiver = $receiver;
        return $this;
    }

}


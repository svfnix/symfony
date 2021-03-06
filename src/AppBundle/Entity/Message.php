<?php

namespace AppBundle\Entity;

use AppBundle\Entity\User;
use AppBundle\Helper\Dictionary;
use AppBundle\Traits\Base;
use AppBundle\Traits\StatusRead;
use AppBundle\Traits\Timestampable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Message
 *
 * @ORM\Table(name="message")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MessageRepository")
 */
class Message
{

    use Base,
        Timestampable,
        StatusRead;

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
     * @ORM\Column(name="title", type="string", length=256)
     * @Assert\NotBlank(message="عنوان پیام را وارد نمایید")
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="text")
     * @Assert\NotBlank(message="متن پیام را وارد نمایید")
     */
    private $message;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\User", cascade={"persist"})
     * @ORM\JoinColumn(name="sender", referencedColumnName="id")
     * @Assert\NotNull(message="ارسال کننده پیام را مشخص نمایید")
     */
    private $sender;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\User", cascade={"persist"})
     * @ORM\JoinColumn(name="receiver", referencedColumnName="id")
     * @Assert\NotNull(message="دریافت کننده پیام را مشخص نمایید")
     */
    private $receiver;

    /**
     * Message constructor.
     */
    function __construct()
    {
        $this->setCreatedAt();
        $this->setStatusReadUnread();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Message
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set message
     *
     * @param string $message
     *
     * @return Message
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set sender
     *
     * @param User $sender
     *
     * @return Message
     */
    public function setSender(User $sender)
    {
        $this->sender = $sender;

        return $this;
    }

    /**
     * Get sender
     *
     * @return User
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * Set receiver
     *
     * @param User $receiver
     *
     * @return Message
     */
    public function setReceiver(User $receiver)
    {
        $this->receiver = $receiver;

        return $this;
    }

    /**
     * Get receiver
     *
     * @return User
     */
    public function getReceiver()
    {
        return $this->receiver;
    }
}


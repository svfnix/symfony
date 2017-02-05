<?php

namespace AppBundle\Entity;

use AppBundle\Traits\Base;
use AppBundle\Traits\Enabled;
use AppBundle\Traits\Timestampable;
use AppBundle\Traits\Visits;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * News
 *
 * @ORM\Table(name="news")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\NewsRepository")
 */
class News
{

    use Base,
        Enabled,
        Visits,
        Timestampable;

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
     * @Assert\NotBlank(message="عنوان خبر را وارد نمایید")
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="summary", type="string", length=1024)
     * @Assert\NotBlank(message="خلاصه خبر را وارد نمایید")
     */
    private $summary;

    /**
     * @var string
     *
     * @ORM\Column(name="news", type="text")
     * @Assert\NotBlank(message="متن خبر را وارد نمایید")
     */
    private $news;

    /**
     * Message constructor.
     */
    function __construct()
    {
        $this->setCreatedAt();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return News
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return News
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getSummary()
    {
        return $this->summary;
    }

    /**
     * @param string $summary
     * @return News
     */
    public function setSummary($summary)
    {
        $this->summary = $summary;
        return $this;
    }

    /**
     * @return string
     */
    public function getNews()
    {
        return $this->news;
    }

    /**
     * @param string $news
     * @return News
     */
    public function setNews($news)
    {
        $this->news = $news;
        return $this;
    }
}


<?php

namespace Admin\News\CategoryBundle\Entity;

use AppBundle\Traits\Base;
use AppBundle\Traits\Enabled;
use AppBundle\Traits\Metadata;
use AppBundle\Traits\Name;
use AppBundle\Traits\Timestampable;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * Cat
 *
 * @ORM\Table(name="news_cat")
 * @ORM\Entity(repositoryClass="News\CategoryBundle\Repository\CatRepository")
 */
class Cat
{
    
    use Base,
        Name,
        Enabled,
        Metadata,
        Timestampable,
        ORMBehaviors\SoftDeletable\SoftDeletable;
    
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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;


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
     * @return Cat
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
}

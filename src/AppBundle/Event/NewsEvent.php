<?php
namespace AppBundle\Event;

use AppBundle\Entity\News;
use Symfony\Component\EventDispatcher\Event;

class NewsEvent extends Event
{
    private $news;

    /**
     * MessageEvent constructor.
     * @param News $news
     */
    function __construct(News $news)
    {
        $this->news = $news;
    }

    /**
     * @return News
     */
    function getNews(){
        return $this->news;
    }
}
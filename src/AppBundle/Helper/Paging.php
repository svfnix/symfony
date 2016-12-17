<?php
/**
 * Created by PhpStorm.
 * User: svf
 * Date: 11/4/16
 * Time: 6:43 PM
 */

namespace AppBundle\Helper;

/**
 * Class Paging
 * @package AppBundle\Helper
 * @see https://www.binpress.com/tutorial/custom-pagination-in-php-and-symfony/117
 */
class Paging
{
    private $totalPages;
    private $currentPage;
    private $resultPerPage;

    /**
     * Paging constructor.
     * @param $page
     * @param $totalCount
     * @param $rpp
     */
    public function __construct($page, $totalCount, $rpp)
    {
        $this->resultPerPage = $rpp;
        $this->currentPage = $page;

        $this->setTotalPages($totalCount, $rpp);
    }

    /*
     * var recCount: the total count of records
     * var $rpp: the record per page
     */

    /**
     * @param $totalCount
     * @param $rpp
     * @return $this
     */
    private function setTotalPages($totalCount, $rpp)
    {
        if (($rpp < 1) || ($rpp > 100) || ($rpp % 5)) {
            $rpp = 20;
        }

        $this->totalPages = ceil($totalCount / $rpp);

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTotalPages()
    {
        return $this->totalPages;
    }

    /**
     * @return array
     */
    public function getPagesList()
    {
        $pageCount = 9;

        if ($this->totalPages <= $pageCount) {
            return range(1, 9);
        }

        if($this->currentPage <=3){
            return array(1,2,3,4,5);
        }

        $counter = $pageCount;
        $result = array();
        $half = floor($pageCount / 2);

        if ($this->currentPage + $half > $this->totalPages)
        {
            while ($counter >= 1)
            {
                $result[] = $this->totalPages - $counter + 1;
                $counter--;
            }

            return $result;

        } else {

            while ($counter >= 1)
            {
                $result[] = $this->currentPage - $counter + $half + 1;
                $counter--;
            }
            
            return $result;
        }
    }
}
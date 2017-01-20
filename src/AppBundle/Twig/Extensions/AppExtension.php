<?php

namespace AppBundle\Twig\Extensions;

use Fisharebest\ExtCalendar\GregorianCalendar;
use Fisharebest\ExtCalendar\PersianCalendar;
use Twig_Extension;
use Twig_Filter;
use Twig_Function;

/**
 * Created by PhpStorm.
 * User: svf
 * Date: 12/5/16
 * Time: 12:30 AM
 */
class AppExtension extends Twig_Extension
{
    /**
     * @return array
     */
    public function getFilters()
    {
        return [
            new Twig_Filter('pnum', [$this, 'pnum']),
            new Twig_Filter('enum', [$this, 'enum']),
        ];
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return [
            new Twig_Function('grid_column', [$this, 'grid_column']),
        ];
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'app_extension';
    }

    /**
     * @param $input
     * @return mixed
     */
    public function pnum($input)
    {

        $input = str_replace('1', '۱', $input);
        $input = str_replace('2', '۲', $input);
        $input = str_replace('3', '۳', $input);
        $input = str_replace('4', '۴', $input);
        $input = str_replace('5', '۵', $input);
        $input = str_replace('6', '۶', $input);
        $input = str_replace('7', '۷', $input);
        $input = str_replace('8', '۸', $input);
        $input = str_replace('9', '۹', $input);
        $input = str_replace('0', '۰', $input);

        return $input;

    }

    /**
     * @param $input
     * @return mixed
     */
    public function enum($input)
    {
        $input = str_replace('۱', '1', $input);
        $input = str_replace('۲', '2', $input);
        $input = str_replace('۳', '3', $input);
        $input = str_replace('۴', '4', $input);
        $input = str_replace('۵', '5', $input);
        $input = str_replace('۶', '6', $input);
        $input = str_replace('۷', '7', $input);
        $input = str_replace('۸', '8', $input);
        $input = str_replace('۹', '9', $input);
        $input = str_replace('۰', '0', $input);

        return $input;

    }

    /**
     * @param $name
     * @param $title
     * @param $filters
     * @return string
     */
    public function grid_column($name, $title, $filters){
        if($filters['order_by'] == $name){
            return $title . ' <i class="fa fa-caret-'.(($filters['sort'] == 'asc') ? 'up' : 'down').'"></i>';
        }

        return $title;
    }

}
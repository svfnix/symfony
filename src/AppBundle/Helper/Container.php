<?php
/**
 * Created by PhpStorm.
 * User: svf
 * Date: 12/16/16
 * Time: 3:47 PM
 */

namespace AppBundle\Helper;


use AppBundle\Traits\Accessors;

class Container
{
    use Accessors;

    function __construct($data)
    {
        foreach ($data as $peoperty => $value) {
            $this->{'set' . ucfirst($peoperty)} = $value;
        }
    }
}
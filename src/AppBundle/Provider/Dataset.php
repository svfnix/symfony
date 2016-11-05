<?php
/**
 * Created by PhpStorm.
 * User: svf
 * Date: 11/5/16
 * Time: 3:26 PM
 */

namespace AppBundle\Provider;


use Doctrine\DBAL\Query\QueryBuilder;

class Dataset
{
    var $query_builder;

    function __construct($table)
    {

        $this->query_builder = new QueryBuilder();
        $this->query_builder
            ->select(*)
            ->
    }

    function setTable
}
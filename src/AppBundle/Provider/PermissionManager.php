<?php
/**
 * Created by PhpStorm.
 * User: svf
 * Date: 10/27/16
 * Time: 12:03 AM
 */

namespace AppBundle\Provider;


class PermissionManager
{
    private $permissions;

    function __construct($_permissions)
    {
        $this->permissions = $_permissions;
    }

    public function __call($method, $args)
    {
        if (!preg_match('/(?P<accessor>can)(?P<property>[A-Z][a-zA-Z0-9]*)/', $method, $match)) {
            throw new BadMethodCallException(sprintf("'%s' does not exist in '%s'.", $method, get_class(__CLASS__)));
        }

        switch ($match['accessor']) {
            case 'can':
                if(in_array(strtoupper($match['property']), $this->permissions)){
                    return true;
                }
                return false;
            break;
        }
    }
}
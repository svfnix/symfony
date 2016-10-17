<?php
/**
 * Created by PhpStorm.
 * User: svf
 * Date: 10/18/16
 * Time: 12:38 AM
 */

namespace AppBundle\Traits;


trait Accessors {

    public function __call($method, $args)
    {
        if ( ! preg_match('/(?P<accessor>set|get)(?P<property>[A-Z][a-zA-Z0-9]*)/', $method, $match) ||
            ! property_exists(__CLASS__, $match['property'] = lcfirst($match['property']))
        ) {
            throw new BadMethodCallException(sprintf(
                "'%s' does not exist in '%s'.", $method, get_class(__CLASS__)
            ));
        }

        switch ($match['accessor']) {
            case 'get':
                return $this->{$match['property']};
            case 'set':
                if ( ! $args) {
                    throw new InvalidArgumentException(sprintf("'%s' requires an argument value.", $method));
                }
                $this->{$match['property']} = $args[0];
                return $this;
        }
    }

}
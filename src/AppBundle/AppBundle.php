<?php

namespace AppBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\Yaml\Yaml;

class AppBundle extends Bundle
{
    protected function getRoles(){
        return Yaml::parse(file_get_contents(__DIR__.'/roles.yml'));
    }
}

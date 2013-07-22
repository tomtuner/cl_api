<?php

namespace AppCore;

class Module
{

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            )
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/module.config.php';
    }

}

?>
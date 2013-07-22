<?php

namespace AppDatabase;

class Module
{

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
                __DIR__ . '/ORM/classes/autoload_classmap.php',
            )
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/module.config.php';
    }

}

?>
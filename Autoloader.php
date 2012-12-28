<?php

define('PATH', dirname(__FILE__));

class Autoloader
{   
    public static function registerAutoload()
    {
        return spl_autoload_register(array(__CLASS__, 'includeClass'));
    }
   

    public static function unregisterAutoload()
    {
        return spl_autoload_unregister(array(__CLASS__, 'includeClass'));
    }
   

    public static function includeClass($class)
    {
        require(PATH . '/' . strtr($class, '_\\', '//') . '.php');
    }
}
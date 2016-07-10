<?php

/**
 * http://jaceju.net/2014-07-27-php-di-container/
 */

class Yunomi
{
    static $map = [];

    static function register($name, $class, $args = null)
    {
        self::$map[$name] = [$class, $args];
    }

    static function get($name)
    {
        if(is_array($name))
        {
            $classes = [];

            foreach($name as $single)
               $classes[] = self::implement($single);

            return $classes;
        }

        return self::implement($name);
    }

    static function implement($name)
    {
        list($class, $args) = isset(self::$map[$name]) ? self::$map[$name]
                                                       : [$name, null];

        if(class_exists($class, true))
        {
            $reflectionClass = new ReflectionClass($class);

            return !empty($args) ? $reflectionClass->newInstanceArgs($args)
                                 : new $class();
        }
    }


    static function inject()
    {
        $args       = func_get_args();
        $callback   = array_pop($args);
        $injectArgs = [];

        foreach($args as $name)
            $injectArgs[] = self::get($name);

        return call_user_func_array($callback, $injectArgs);
    }

    static function resolve($name)
    {
        if(!class_exists($name, true))
            return null;

        $reflectionClass       = new ReflectionClass($name);
        $reflectionConstructor = $reflectionClass->getConstructor();
        $reflectionParams      = $reflectionConstructor->getParameters();

        $args = [];

        foreach($reflectionParams as $param)
        {
            $class  = $param->getClass()->getName();
            $args[] = self::get($class);
        }

        return !empty($args) ? $reflectionClass->newInstanceArgs($args)
                             : new $class();
    }
}
?>
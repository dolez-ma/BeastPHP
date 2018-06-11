<?php
/**
 * @package Beast
 * @licence MIT
 * @author dolezma
 */

namespace BeastPHP\DependencyInjection;


use BeastPHP\Utility\Lang;
use Exception;
use ReflectionClass;

class Container
{
    /** @var array Contains the instances of classes  */
    protected static $instances = [];

    /** @var array Contains boolean values, if the class has a parent then the value is true */
    protected static $relations = [];

    /**
     * Returns the instance of the class given
     * @param string $className
     * @param string $parentClassName
     * @return mixed
     * @throws \Exception
     */
    public static function get($className, $parentClassName = ''){

        // Check if parentClassName exists
        if($parentClassName){
            self::$relations[$className][$parentClassName] = true;
        }

        // Check if there is a cyclic dependency with the parent class
        if($parentClassName && isset(self::$relations[$parentClassName]) && isset(self::$relations[$parentClassName][$className])){
            $message = sprintf(Lang::translate("exception:cyclic_dependency"), $className , $parentClassName, $className);
            throw new Exception($message);
        }

        // If the instance of the class doesn't exist then create it.
        if(!isset(self::$instances[$className])){
            self::$instances[$className] = self::create($className, $parentClassName);
        }

        return self::$instances[$className];
    }

    /**
     * Creates an instance of the className provided.
     * @param string $className
     * @param string $parentClassName
     * @return mixed
     * @throws \Exception
     */
    public static function create($className, $parentClassName = ''){

        // Checks whether the class exists.
        if(!class_exists($className)){
            $message = 'could not create instance of "' . $className . '"';
            if($parentClassName){
                $message .= ', requis par ' . $parentClassName . '"';
            }
            throw new Exception($message);
        }

        // Instanciate the object
        $reflection = new ReflectionClass($className);
        $construct  = $reflection->getConstructor();

        // test if constructor exists
        if(!$construct){
            return new $className();
        }

        // get the params of the constructor
        $params = $construct->getParameters();

        // build the dependencies of the constructor
        $dependencies = [];
        foreach ($params as $param){
            $subClassName = $param->name;
            if($param->getClass()){
                $subClassName = $param->getClass()->name;
            }
            $dependencies[] = self::get($subClassName, $className);
        }

        return (new ReflectionClass($className))->newInstanceArgs($dependencies);


    }

}
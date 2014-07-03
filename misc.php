<?php

/**
 * Define Class UnexpectedArgumentException - nothing special - just for more detailed Information
 */
class UnexpectedArgumentException extends Exception
{

}

class NotImplementedException extends Exception
{

}

/**
 * Class Struct - disable getter and setter
 */
abstract class ValueStruct
{
    protected $value = null;

    public function __get( $property )
    {
        if ($property != "value")
        {
            throw new RuntimeException( 'Trying to get non-existing property ' . $property );
        }
        else
        {
            return $this->value;
        }
    }

    public function __set( $property, $value )
    {
        if ($property != "value")
        {
            throw new RuntimeException( 'Trying to set non-existing property ' . $property );
        }
        else
        {
            throw new NotImplementedException('You need to define this setter in your class!');
        }
    }
}

/**
 * Class casting from http://stackoverflow.com/questions/2226103/how-to-cast-objects-in-php
 *
 * @param string|object $destination
 * @param object $sourceObject
 * @return object
 */
function cast($destination, $sourceObject)
{
    if (is_string($destination)) {
        $destination = new $destination();
    }
    $sourceReflection = new ReflectionObject($sourceObject);
    $destinationReflection = new ReflectionObject($destination);
    $sourceProperties = $sourceReflection->getProperties();
    foreach ($sourceProperties as $sourceProperty) {
        $sourceProperty->setAccessible(true);
        $name = $sourceProperty->getName();
        $value = $sourceProperty->getValue($sourceObject);
        if ($destinationReflection->hasProperty($name)) {
            $propDest = $destinationReflection->getProperty($name);
            $propDest->setAccessible(true);
            $propDest->setValue($destination,$value);
        } else {
            $destination->$name = $value;
        }
    }
    return $destination;
}

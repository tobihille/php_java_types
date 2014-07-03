<?php

class ConvChar extends ValueStruct
{

    public function __construct($initial_value, $strict = true)
    {
        if ( ( is_string($initial_value) && strlen($initial_value) === 1) ||
            ($initial_value instanceof ConvChar) ||
            ($initial_value instanceof ConvString && $initial_value->length() === 1)
        )
        {
            $this->value = $initial_value;
        }
        else
        {
            throw new InvalidArgumentException('Given value "'.$initial_value.'" is not a Character');
        }
    }

    public function __toString()
    {
        return (string) $this->value;
    }

    public function __set( $property, $value )
    {
        throw new BadFunctionCallException('you are not allowed to call this function.');
    }
}

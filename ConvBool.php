<?php

class ConvBool extends SplBool
{
    public static function parseBoolean($value)
    {
        if (is_bool($value))
        {
            return new ConvBool($value);
        }

        if ($value instanceof ConvString)
        {
            $value = $value->getValue();
        }

        if (is_string($value))
        {
            if ($value === '1' || mb_strtolower($value) === 'true' )
            {
                return new ConvBool(true);
            }
            if ($value === '0' || mb_strtolower($value) === 'false' )
            {
                return new ConvBool(false);
            }
        }

        if ( is_integer($value) )
        {
            if ($value === 1)
            {
                return new ConvBool(true);
            }
            if ($value === 0)
            {
                return new ConvBool(false);
            }
        }

        throw new UnexpectedArgumentException('Given value "'.$value.'" cannot be converted into ConvBool.');
    }
}

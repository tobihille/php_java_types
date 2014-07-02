<?php

class ConvArray extends SplFixedArray
{
    public static function fromArray($array, $saveIndexes = true)
    {
        $foo = parent::fromArray($array, $saveIndexes);
        return cast('ConvArray', $foo);
    }
}

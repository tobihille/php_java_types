<?php

require_once('typeLoader.php');

try
{
    $foo = new ConvString("1234567890");

    return $foo->charAt('ö');
}
catch (Exception $e)
{
    $lb = "\n<br>";

    echo get_class($e).$lb;
    echo $e->getMessage().$lb;
    echo nl2br($e->getTraceAsString());
}

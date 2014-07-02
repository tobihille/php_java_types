<?php

require_once('typeLoader.php');
$lb = "\n<br>";

try
{
    $foo = new ConvString("1234567890");

    echo $foo->charAt(2).$lb;
    echo $foo->startsWith('123').$lb;
    echo $foo->endsWith('890').$lb;
}
catch (Exception $e)
{
    echo get_class($e).$lb;
    echo $e->getMessage().$lb;
    echo nl2br($e->getTraceAsString());
}

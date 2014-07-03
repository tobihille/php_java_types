<?php

require_once('typeLoader.php');
$lb = "\n<br>";

try
{
    $foo = new ConvChar("Ö");

    echo $foo->charCount().$lb;
}
catch (Exception $e)
{
    echo get_class($e).$lb;
    echo $e->getMessage().$lb;
    echo nl2br($e->getTraceAsString());
}

<?php

function endsWith($haystack, $needle)
{
    return $needle === "" || substr($haystack, -strlen($needle)) === $needle;
}

$filePath = dirname(__FILE__);
if ( !endsWith($filePath, DIRECTORY_SEPARATOR))
{
    $filePath .= '/';
}

require_once($filePath.'ConvString.php');
require_once($filePath.'misc.php');
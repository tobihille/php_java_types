<?php

function endsWith($haystack, $needle)
{
    return $needle === "" || mb_substr($haystack, -mb_strlen($needle)) === $needle;
}

$filePath = dirname(__FILE__);
if ( !endsWith($filePath, DIRECTORY_SEPARATOR))
{
    $filePath .= '/';
}

require_once($filePath.'misc.php');
require_once($filePath.'ConvBool.php');
require_once($filePath.'ConvChar.php');
require_once($filePath.'ConvInt.php');
require_once($filePath.'ConvString.php');


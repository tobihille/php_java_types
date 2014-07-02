<?php

class ConvString extends SplString
{

    /**
     * @param $i
     * @return mixed
     */
    public function charAt($i)
    {
        if (is_integer($i) || $i instanceof SplInt)
        {
            return $this[$i];
        }
        else
        {
            $this->throwException(new SplString('integer'), $i);
        }
    }

    function startsWith($haystack, $needle)
    {
        return $needle === "" || strpos($haystack, $needle) === 0;
    }

    function endsWith($haystack, $needle)
    {
        return $needle === "" || substr($haystack, -strlen($needle)) === $needle;
    }

    protected function throwException(SplString $expectedType, $value)
    {
        $classname = '';

        if ( is_object($value) )
        {
            $classname = get_class($value);
        }
        else
        {
            ob_start();
            var_dump($value);
            $res = ob_get_clean();
            $res = strip_tags($res); //jus in case we have XDebug in pretty mode
            $res = explode(' ', $res, 2);
            $classname = $res[0];
        }
        throw new UnexpectedArgumentException('Expected integer, found '.$classname);
    }
}

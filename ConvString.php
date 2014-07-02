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
            $xx = $this->getValue();
            return mb_substr($xx, $i, 1);
        }
        else
        {
            $this->throwException(new SplString('integer'), $i);
        }
    }

    public function startsWith($needle)
    {
        return $needle === "" || strpos($this->getValue(), $needle) === 0;
    }

    public function endsWith($needle)
    {
        return $needle === "" || substr($this->getValue(), -strlen($needle)) === $needle;
    }

    protected function getValue()
    {
        ob_start();
        echo $this;
        $value = ob_get_clean();
        return $value;
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
        throw new UnexpectedArgumentException('Expected '.$expectedType.', found '.$classname);
    }
}

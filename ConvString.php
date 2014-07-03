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
            return new ConvChar( mb_substr($xx, $i, 1) );
        }
        else
        {
            $this->throwException(new SplString('integer'), $i);
        }
    }

    public function compareTo($str)
    {
        if ( is_string($str) || $str instanceof SplString)
        {
            return new ConvBool( strcmp($this->getValue(), $str) );
        }
        else
        {
            $this->throwException(new SplString('string'), $str);
        }
    }

    public function concat($str)
    {
        if ( is_string($str) || $str instanceof SplString)
        {
            return new ConvString($this->getValue().$str);
        }
        else
        {
            $this->throwException(new SplString('string'), $str);
        }
    }

    public function contains($str)
    {
        if ( is_string($str) || $str instanceof SplString)
        {
            return new ConvBool( mb_strpos($this->getValue(), $str) !== false );
        }
        else
        {
            $this->throwException(new SplString('string'), $str);
        }
    }

    public function endsWith($needle)
    {
        if (is_string($needle) || $needle instanceof SplString)
        {
            return new ConvBool( $needle === "" || mb_substr($this->getValue(), -mb_strlen($needle)) === $needle );
        }
        else
        {
            $this->throwException(new SplString('string'), $needle);
        }
    }

    public function indexOf($str, $idx = 0)
    {
        if (is_string($str) || $str instanceof SplString)
        {
            if (is_integer($idx) || $idx instanceof SplInt)
            {
                return new ConvInt( mb_strpos($this->getValue(), $str, $idx) );
            }
            else
            {
                $this->throwException(new SplString('integer'), $idx);
            }
        }
        else
        {
            $this->throwException(new SplString('string'), $str);
        }
    }

    public function length()
    {
        return new ConvInt( mb_strlen($this->getValue()) );
    }

    public function matches($regex)
    {
        if (is_string($regex) || $regex instanceof SplString)
        {
            return new ConvBool( preg_match($regex, $this->getValue()) === 1 );
        }
        else
        {
            $this->throwException(new SplString('string'), $regex);
        }
    }

    public function replace($part, $pattern)
    {
        if (is_string($part) || is_string($pattern) ||
            $part instanceof SplString || $pattern instanceof SplString)
        {
            return new ConvString( str_replace($part, $pattern, $this->getValue()) );
        }
        else
        {
            if (is_string($part) || $part instanceof SplString)
            {
                $this->throwException(new SplString('string'), $pattern);
            }
            else
            {
                $this->throwException(new SplString('string'), $part);
            }
        }
    }

    public function startsWith($needle)
    {
        if (is_string($needle) || $needle instanceof SplString)
        {
            return new ConvBool( $needle === "" || mb_strpos($this->getValue(), $needle) === 0 );
        }
        else
        {
            $this->throwException(new SplString('string'), $needle);
        }
    }

    public function split($char, $limit = 0)
    {
        if (is_string($char) && mb_strlen($char) == 1 || $char instanceof ConvChar)
        {
            $ret = array();
            if ( empty($limit) )
            {
                $ret = explode($char, $this->getValue());
            }
            else
            {
                if (is_integer($limit) || $limit instanceof SplInt)
                {
                    $ret = explode($char, $this->getValue(), $limit);
                }
                else
                {
                    $this->throwException(new SplString('integer'), $limit);
                }
            }
            return (new ConvArray())->fromArray($ret);
        }
        else
        {
            $this->throwException(new SplString('char'), $char);
        }
    }

    public function substring($start, $length = PHP_INT_MAX)
    {
        if (is_integer($start) || $start instanceof SplInt)
        {
            if (is_integer($length) || $length instanceof SplInt)
            {
                return new ConvString( mb_substr($this->getValue(), $start, $length) );
            }
            else
            {
                $this->throwException(new SplString('integer'), $length);
            }
        }
        else
        {
            $this->throwException(new SplString('integer'), $start);
        }
    }

    public function toLowercase()
    {
        return new ConvString( mb_strtolower($this->getValue()) );
    }

    public function toUppercase()
    {
        return new ConvString( mb_strtoupper($this->getValue()) );
    }

    public function trim($charList = null)
    {
        if (!empty($charList))
        {
            if (is_string($charList) || $charList instanceof SplString )
            {
                return new ConvString( trim($this->getValue(), $charList) );
            }
            else
            {
                $this->throwException(new SplString('string'), $charList);
            }
        }
        return new ConvString( trim($this->getValue()) );
    }

    public function getValue()
    {
        /* old and outdated:
        ob_start();
        echo $this;
        $value = ob_get_clean();
        return $value;
        */
        //new and sexy:
        return $this;
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

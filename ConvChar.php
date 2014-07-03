<?php

class ConvChar extends ValueStruct
{

    public function __construct($initial_value, $strict = true)
    {
        if ( ( is_string($initial_value) && mb_strlen($initial_value) === 1) ||
            ($initial_value instanceof ConvChar) ||
            ($initial_value instanceof ConvString && $initial_value->length() === 1)
        )
        {
            $this->value = $initial_value;
        }
        else
        {
            throw new InvalidArgumentException('Given value "'.$initial_value.'" is not a Character');
        }
    }

    public function __toString()
    {
        return (string) $this->value;
    }

    public function __set( $property, $value )
    {
        throw new BadFunctionCallException('you are not allowed to call this function.');
    }

    public function charCount()
    {
        $foo = $this->utf8_to_unicode($this->getValue());
/*
        U+0000 — U+007F: 1 byte: 0xxxxxxx
    U+0080 — U+07FF: 2 bytes: 110xxxxx 10xxxxxx
    U+0800 — U+FFFF: 3 bytes: 1110xxxx 10xxxxxx 10xxxxxx
    U+10000 — U+10FFFF: 4 bytes: 11110xxx 10xxxxxx 10xxxxxx 10xxxxxx
*/
    }

    /**
     * original function by Scott Reynen: http://randomchaos.com/documents/?source=php_and_unicode
     * @param $str
     * @return array
     */
    private function utf8_to_unicode( $str ) {

        $unicode = 0;
        $values = array();
        $lookingFor = 1;

        //!!! this has to stay 'simple' strlen !!!
        for ($i = 0; $i < strlen( $str ); $i++ ) {

            $thisValue = ord( $str[ $i ] );

            if ( $thisValue < 128 ) $unicode = $thisValue;
            else {

                if ( count( $values ) == 0 ) $lookingFor = ( $thisValue < 224 ) ? 2 : 3;

                $values[] = $thisValue;

                if ( count( $values ) == $lookingFor ) {

                    $number = ( $lookingFor == 3 ) ?
                        ( ( $values[0] % 16 ) * 4096 ) + ( ( $values[1] % 64 ) * 64 ) + ( $values[2] % 64 ):
                        ( ( $values[0] % 32 ) * 64 ) + ( $values[1] % 64 );

                    $unicode = $number;
                    $values = array();
                    $lookingFor = 1;

                } // if

            } // if

        } // for

        return $unicode[0];

    } // utf8_to_unicode

    public function getValue()
    {
        return $this->value;
    }
}

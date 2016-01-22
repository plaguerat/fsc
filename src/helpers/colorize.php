<?php

/**
 * Colorizes the given string input for most terminals
 * @param  [str] $string String to colorize
 * @param  [str|int] $color  Numeric value of the color to add
 * @return [str]         The colorized string
 */
function colorize($string, $color)
{
    return sprintf("\033[%sm%s\033[0m", $color, $string);
}

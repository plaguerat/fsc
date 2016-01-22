<?php

/**
 * Decorate string for output to terminal
 * @param  [str] $string String to decorate
 * @param  [str|int] $decor  Pattern used for decoration
 * @return [str]         Teh decorated string
 */
function decorateString($string, $decor)
{
    return sprintf("\e[%sm%s\e[0m", $decor, $string);
};

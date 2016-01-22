<?php

/**
 * Wrapper using fwrite to output to STDOUT
 *
 * This primarily laziness on my part. I prefer using fwrite but am tired of
 * typeing fwrite(STDOUT, "blah") constantly
 *
 * @param  [str] $string String to write
 * @return [void]
 */
function twrite($string)
{
    fwrite(STDOUT, $string);
}

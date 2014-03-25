<?php

/**
 * @param mixed $var
 */
function dump($var)
{
    if (function_exists('ladybug_dump')) {
        ladybug_dump($var);
    } else {
        var_dump($var);
    }
}

/**
 * @param mixed $var
 */
function dumpdie($var)
{
    if (function_exists('ladybug_dump_die')) {
        ladybug_dump_die($var);
    } else {
        var_dump($var);
        die();
    }
}

<?php

namespace Knlv;

/**
 * Memoizes function's return value
 *
 * @var callable $function
 * @return callable
 */
function memoize($function)
{
    if (!is_callable($function)) {
        throw new \InvalidArgumentException(sprintf(
            'Expected callable argument. %s given',
            is_object($function) ? get_class($function) : gettype($function)
        ));
        
    }
    $memoized = array();

    return function () use (&$memoized, $function) {
        $args = func_get_args();
        $key  = md5(serialize($args));

        if (!isset($memoized[$key])) {
            $memoized[$key] = call_user_func_array($function, $args);
        }

        return $memoized[$key];
    };
}

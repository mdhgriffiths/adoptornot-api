<?php

namespace AdoptOrNot\Api;

/**
 * Get value of environment variable or return default if undefined
 * @param $varname
 * @param NULL $default
 * @return NULL|string
 */
function env ($varname, $default = NULL) {
    $value = getenv ($varname);
    if ($value === false) {
        return $default;
    }
    return $value;
}
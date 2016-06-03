<?php

namespace AdoptOrNot\Api\Util;
use InvalidArgumentException;

/**
 * Json utility tools
 */
abstract class JsonTools {

    /**
     * Decode JSON data
     * @param string $json JSON data
     * @throws InvalidArgumentException If invalid JSON
     */
    public static function decode($json) {
        $data = json_decode($json, true);
        if ($error = JsonTools::getLastError()) {
            throw new InvalidArgumentException(sprintf(
                'Failed to decode JSON [%s]',
                $error
            ));
        }
        return $data;
    }

    /**
     * Get last JSON error message
     * @return string|false
     */
    protected static function getLastError() {
        switch (json_last_error()) {
            case JSON_ERROR_NONE:
                return false;
            case JSON_ERROR_DEPTH:
                return 'Maximum stack depth exceeded';
            case JSON_ERROR_STATE_MISMATCH:
                return 'Underflow or the modes mismatch';
            case JSON_ERROR_CTRL_CHAR:
                return 'Unexpected control character found';
            case JSON_ERROR_SYNTAX:
                return 'Syntax error, malformed JSON';
            case JSON_ERROR_UTF8:
                return 'Malformed UTF-8 characters, possibly incorrectly encoded';
            default:
                return 'Unknown error';
        }
    }

}

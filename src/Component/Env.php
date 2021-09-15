<?php
/**
 * This file is part of the yannoff/composer-dotenv-handler project
 *
 * @copyright 2019 - Yannoff
 * @licence   MIT License
 * @author    Yannoff (https://github.com/yannoff)
 */

namespace Yannoff\DotenvHandler\Component;

use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\Dotenv\Exception\FormatException;

/**
 * Class Env
 * DotEnv data manipulation class
 *
 * @package Yannoff\DotenvHandler
 */
class Env
{

    /** @var Dotenv */
    static protected $dotenv;

    /**
     * Getter for synfony dotenv singleton instance
     *
     * @return Dotenv
     */
    protected static function getDotEnv()
    {
        if (null === self::$dotenv) {
            self::$dotenv = new Dotenv();
        }

        return self::$dotenv;
    }

    /**
     * Parses the contents of an .env file.
     *
     * @param array|string  $data The data to be parsed
     * @param string        $path The original file name where data where stored (used for more meaningful error messages)
     *
     * @return array An array of env variables
     *
     * @throws FormatException when a file has a syntax error
     */
    public static function parse($data, $path = '.env')
    {
        if (!is_string($data)) {
            $data = implode("\n", $data);
        }

        return self::getDotEnv()->parse($data, $path);
    }

    /**
     * Dumps data in a format suitable for .env file
     *
     * @param array $data
     *
     * @return string
     */
    public static function dump(array $data)
    {
        $buffer = [];

        foreach ($data as $var => $val) {
            // JSON strings loose their wrapping quotes in the process, need to put them back afterward
            // @see https://github.com/yannoff/composer-dotenv-handler/issues/6
            if (self::isJsonValue($val)) {
                $val = sprintf("'%s'", $val);
            }
            $buffer[] = sprintf('%s=%s', $var, $val);
        }

        return implode("\n", $buffer);
    }

    /**
     * Check whether the string is a JSON representation
     *
     * @param string $value
     *
     * @return bool
     */
    protected static function isJsonValue($value)
    {
        return is_array(json_decode($value, true));
    }
}

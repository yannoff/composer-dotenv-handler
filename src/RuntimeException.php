<?php
/**
 * This file is part of the yannoff/composer-dotenv-handler project
 *
 * @copyright 2019 - Yannoff
 * @licence   MIT License
 * @author    Yannoff (https://github.com/yannoff)
 */

namespace Yannoff\DotenvHandler;

/**
 * Class RuntimeException
 *
 * @package Yannoff\DotenvHandler
 */
class RuntimeException extends \RuntimeException
{
    /**
     * The exception constructor is intended to be invoked like the PHP's built-in printf()
     *
     * @param string $format The raw message or format string
     * @param mixed  ...$arg The optional arguments to build the formatted string
     */
    public function __construct(string $format = "", ...$arg)
    {
        $arguments = func_get_args();
        $message = call_user_func_array('sprintf', $arguments);
        parent::__construct($message, 0);
    }
}

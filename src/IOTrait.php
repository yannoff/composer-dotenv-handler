<?php
/**
 * Created by PhpStorm.
 * User: yann
 * Date: 16/02/19
 * Time: 22:15
 */

namespace Yannoff\DotenvHandler;

use Composer\IO\IOInterface;

/**
 * Trait IOTrait
 * @package Yannoff\DotenvHandler
 */
trait IOTrait
{
    /** @var IOInterface */
    protected $io;

    /**
     * Setter for IO
     *
     * @param IOInterface $io
     */
    protected function setIO(IOInterface $io)
    {
        $this->io = $io;
    }

    /**
     * Display a formatted message on standard output
     * Intended to be called in a PHP's built-in printf() fashion
     *
     * @param string $format The raw message or format string
     * @param mixed  ...$arg The optional arguments to build the formatted string
     * @return mixed
     */
    protected function printf($format, ...$arg)
    {
        $message = call_user_func_array('sprintf', func_get_args());
        $this->io->write($message);

        return $message;
    }

    /**
     * Ask a formatted question on standard output then return the result
     * Intended to be called in a PHP's built-in printf() fashion
     *
     * @param string $format  The raw message or format string
     * @param mixed  $default The default response value
     * @param mixed  ...$arg  The optional arguments to build the formatted string
     * @return mixed
     */
    protected function askf($format, $default, ...$arg)
    {
        $arguments = func_get_args();
        // We remove $default value from the invoking args
        unset($arguments[1]);
        $message = call_user_func_array('sprintf', $arguments);
        $message .= sprintf(' (<comment>%s</comment>)', $default);
        $value = $this->io->ask($message, $default);

        return $value;
    }
}
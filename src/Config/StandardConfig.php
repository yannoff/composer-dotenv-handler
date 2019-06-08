<?php
/**
 * This file is part of the yannoff/composer-dotenv-handler project
 *
 * @copyright 2019 - Yannoff
 * @licence   MIT License
 * @author    Yannoff (https://github.com/yannoff)
 */

namespace Yannoff\DotenvHandler\Config;

/**
 * Class StandardConfig
 * Config handler for normal behavior mode
 *
 * @package Yannoff\DotenvHandler\Config\Config
 */
class StandardConfig extends Config
{
    /**
     * Getter for the distribution filename
     *
     * @return string
     */
    public function getDistFile()
    {
        return $this->config['dist-file'];
    }

    /**
     * Getter for the real dotenv filename
     *
     * @return string
     */
    public function getRealFile()
    {
        return $this->config['file'];
    }
}

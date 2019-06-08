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
 * Class FlexConfig
 * Config handler for Symfony Flex behavior mode
 *
 * @package Yannoff\DotenvHandler\Config\Config
 */
class FlexConfig extends Config
{
    /**
     * Getter for the distribution filename
     *
     * @return string
     */
    public function getDistFile()
    {
        return '.env';
    }

    /**
     * Getter for the real dotenv filename
     *
     * @return mixed|string
     */
    public function getRealFile()
    {
        return sprintf('.env.%s', $this->getExecutionEnv());
    }
}
